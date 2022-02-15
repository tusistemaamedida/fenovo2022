<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\InvoicesRepository;
use App\Models\Movement;
use App\Models\MovementProduct;
use App\Models\Store;
use App\Models\Customer;
use App\Models\Iibb;
use Afip;
use stdClass;

class InvoiceController extends Controller
{
    private $invoiceRepository;
    private $client;
    private $cuit_afip;
    private $cert_folder;
    private $pto_vta;
    private $concepto_afip;
    private $document_type;
    private $afip;

    public function __construct( InvoicesRepository $invoiceRepository) {
        $this->client = null;
        $this->cuit_afip =20287937149;
        $this->cuit_afip_folder = 'dev/';
        $this->pto_vta = 17;
        $this->concepto_afip = 1; // (1)Productos, (2)Servicios, (3)Productos y Servicios
        $this->document_type =  80; // (80) CUIT
        $this->invoiceRepository = $invoiceRepository;

        $this->afip =  new Afip([
            'CUIT'=> $this->cuit_afip,
            'res_folder'=>  __DIR__.'/../../../certs/'.$this->cuit_afip_folder,
            'ta_folder'=>  __DIR__.'/../../../certs/'.$this->cuit_afip_folder
        ]);
    }

    public function index(Request $request){
        if ($request->ajax()) {
            $invoices = $this->invoiceRepository->all();
            return Datatables::of($invoices)
                ->addIndexColumn()
                ->addColumn('fecha', function ($invoice) {
                    return \Carbon\Carbon::parse($invoice->updated_at)->format('d/m/Y');
                })
                ->addColumn('acciones', function ($invoice) {
                    $actions = '<a class="dropdown-item" href="'. route('$product->edit', ['id' => $invoice->id]) . '"><i class="fa fa-edit"></i> Editar</a>';
                    return $actions;
                })
                ->rawColumns(['acciones'])
                ->make(true);
        }

        return view('admin.invoice.list');
    }

    public function generateInvoicePdf(Request $request){
        $movement_id = 525;
        $invoice = $this->invoiceRepository->getByMovement($movement_id);
        if(!is_null($invoice->cae)){
            $productos = MovementProduct::where('movement_id',$movement_id)->where('invoice',1)->get();
            $view =  \View::make('print.invoice',compact('invoice'))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->setPaper([0, 0, 360, 560], 'portrait');
            $pdf->loadHTML($view);
            return $pdf->stream('opf-'.$opf->id.'.pdf');
        }
    }

    public function create(Request $request){
        try {
            $movement_id = 525;
            $movement = Movement::where('id',$movement_id)->with('movement_salida_products')->firstOrFail();
            $result = $this->createVoucher($movement);
            $invoice = $this->invoiceRepository->getByMovement($movement_id);
            if($result['status']){
                if(isset($invoice)){
                    $this->invoiceRepository->fill($invoice->id,[
                        'error' => null,
                        'cae' => $result['response_afip']['CAE'],
                        'expiration' => $result['response_afip']['CAEFchVto']
                    ]);
                }
                return 'invoice creado';
            }else{
                if(isset($invoice)) $this->invoiceRepository->fill($invoice->id,[ 'error' => $result['error'] ]);
                return $result['error'];
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    private function createVoucher($movement){
        $data_invoice = $this->dataInvoice($movement);
        if($data_invoice['status']){
            try {
              $response_afip = null;
              $snake_case_data = $this->get_snake_case($data_invoice['data']);
              $more_data = new stdClass;

              $more_data->movement_id = $movement->id;
              $more_data->client_name =  strtoupper($data_invoice['client']->razon_social);
              $more_data->client_address =  strtoupper($data_invoice['client']->address . ' '.$data_invoice['client']->city . ' '.$data_invoice['client']->state);
              $more_data->client_cuit =  $data_invoice['client']->cuit;
              $more_data->client_iva_type =  $this->get_iva_type($data_invoice['client']->iva_type);              ;
              $more_data->voucher_number =  str_pad($this->pto_vta, 5, "0", STR_PAD_LEFT) .'-'.str_pad($data_invoice['numero_de_factura'], 8, "0", STR_PAD_LEFT);
              $more_data->iibb =  $data_invoice['iibb'];

              $final_data = array_merge($snake_case_data,(array) $more_data);

              $this->invoiceRepository->create($final_data);

              if($this->check_type($movement->type)){
                $response_afip = $this->afip->ElectronicBilling->CreateVoucher($data_invoice['data']);
              }

              return ['status' => true, 'data_invoice' => $data_invoice, 'response_afip' => $response_afip];
            } catch (\Exception $e) {
                return ['status' => false, 'data_invoice' => $data_invoice, 'error' => $e->getMessage()];
            }
        }

          return 'error';//{status:false, data_invoice:null, error:data_invoice.error};
    }

    private function dataInvoice($movement){
        try {
          $client = $this->dataClient($movement->type,(int)$movement->to);
          if($client){
            $last_voucher = 0;
            $fecha_servicio_desde = $fecha_servicio_hasta = $fecha_vencimiento_pago = 0;
            $concepto = $this->concepto_afip;
            $punto_de_venta = $this->pto_vta;
            $tipo_de_factura = $this->voucherType($this->client->iva_type);
            $tipo_de_documento = $this->document_type;
            $numero_de_documento = $this->client->cuit;
            $last_voucher = $this->afip->ElectronicBilling->GetLastVoucher($punto_de_venta, $tipo_de_factura);
            $numero_de_factura = $last_voucher+1;
            $fecha = date('Y-m-d');
            $iibb = Iibb::where('state',$this->client->state)->first();
            $iibb = ($iibb)?$iibb->value:0;

            $importe = $this->importes($movement->movement_products);
            $importe_gravado = $importe['gravado'];
            $importe_exento_iva = 0;
            $importe_iva = $importe['iva'];

            $importe_no_gravado = ($iibb>0)?($importe_gravado * $iibb /100):0;

            $dataAfip =[
              'CantReg' 	=>  1, // Cantidad de facturas a registrar
              'PtoVta' 	    =>  $punto_de_venta,
              'CbteTipo' 	=>  $tipo_de_factura,
              'Concepto' 	=>  $concepto,
              'DocTipo' 	=>  $tipo_de_documento,
              'DocNro' 	    =>  $numero_de_documento,
              'CbteDesde'   =>  $numero_de_factura,
              'CbteHasta'   =>  $numero_de_factura,
              'CbteFch' 	=>  intval(str_replace('-', '', $fecha)),
              'FchServDesde'=>  $fecha_servicio_desde,
              'FchServHasta'=>  $fecha_servicio_hasta,
              'FchVtoPago'  =>  $fecha_vencimiento_pago,
              'ImpTotal' 	=>  round(($importe_gravado + $importe_iva + $importe_exento_iva + $importe_no_gravado),2),
              'ImpTotConc'  =>  round($importe_no_gravado,2), // Importe neto no gravado
              'ImpNeto' 	=>  $importe_gravado,
              'ImpOpEx' 	=>  $importe_exento_iva,
              'ImpIVA' 	    =>  $importe_iva,
              'ImpTrib' 	=>  0, //Importe total de tributos
              'MonId' 	    =>  'PES', //Tipo de moneda usada en la factura ('PES' = pesos argentinos)
              'MonCotiz' 	=>  1, // Cotización de la moneda usada (1 para pesos argentinos)
            ];

            if($importe_gravado > 0 || $importe_iva > 0) $dataAfip['Iva'] = $importe['ivas'];

            return [
                'status'=> true,
                'data' => $dataAfip ,
                'client' => $this->client,
                'numero_de_factura' => $numero_de_factura,
                'iibb' => $iibb
            ];
          }
          return ['status' => false, 'error' => "Cliente o store no encontrado en el movimiento ". $movement->id];
        } catch (\Exception $e) {
          return $e->getMessage();
        }
    }

    private function importes($products){
        $gravado = 0;
        $iva = 0;
        $ivas = [];
        $obj_iva = new stdClass;

        foreach ($products as $product) {
            if($product->invoice && $product->egress > 0){
                $tasiva = $product->tasiva;
                $subtotal = $product->egress * $product->unit_price; // cantidad de salida por el precio del producto
                $iva_price = ( $subtotal * $tasiva)/100; // iva del subtotal del precio

                $gravado += $subtotal;
                $iva += $iva_price;

                $id_alicuota = $this->get_alicuota_id($tasiva);

                $obj_iva->Id = $id_alicuota;
                $obj_iva->BaseImp = $BaseImp = round($subtotal,2);
                $obj_iva->Importe = $Importe = round($iva_price,2);
                $insert_new = true;

                if(count($ivas)){
                    for ($cont=0; $cont <count($ivas) ; $cont++) {
                        $alicuota = $ivas[$cont];
                        if($alicuota->Id == $id_alicuota){
                            $alicuota->BaseImp = round(($alicuota->BaseImp + $BaseImp),2);
                            $alicuota->Importe = round(($alicuota->Importe + $Importe),2);
                            $insert_new = false;
                        }
                    }
                    if($insert_new)array_push($ivas,$obj_iva);
                }else{
                    array_push($ivas,$obj_iva);
                }
            }
        }
        return ['gravado' => round($gravado,2), 'iva' => round($iva,2), 'ivas' => $ivas];
    }

    private function get_alicuota_id($iva){
        switch ($iva) {
          case 27:
            return 6;
          case 21:
            return 5;
          case 10.5:
            return 4;
          case 5:
            return 8;
          case 2.5:
            return 9;
          case 0:
            return 3;
          default:
            return 3;
        }
    }

    private function dataClient($type,$id){
        switch ($type) {
          case 'VENTA':
          case 'TRASLADO':
            $this->client = Store::where('id',$id)->where('active', 1)->with('region')->first();
            return true;
          case 'VENTACLIENTE':
            $this->client = Customer::where('id',$id)->where('active', 1)->with('store')->first();
            return true;
          default:
            return false;
        }
    }

    private function voucherType($type){
        switch ($type) {
          case 'RI':
            return  1; //FACTURA A
          default:
            return  6; //FACTURA B
        }
    }

    private function get_snake_case($data){
        return [
          'cant_reg'=>$data['CantReg'],
          'pto_vta'=>$data['PtoVta'],
          'cbte_tipo'=>$data['CbteTipo'],
          'concepto'=>$data['Concepto'],
          'doc_tipo'=>$data['DocTipo'],
          'doc_nro'=>$data['DocNro'],
          'cbte_desde'=>$data['CbteDesde'],
          'cbte_hasta'=>$data['CbteHasta'],
          'cbte_fch'=>$data['CbteFch'],
          'fch_serv_desde'=>$data['FchServDesde'],
          'fch_serv_hasta'=>$data['FchServHasta'],
          'fch_vto_pago'=>$data['FchVtoPago'],
          'imp_total'=>$data['ImpTotal'],
          'imp_tot_conc'=>$data['ImpTotConc'],
          'imp_neto'=>$data['ImpNeto'],
          'imp_op_ex'=>$data['ImpOpEx'],
          'imp_iva'=>$data['ImpIVA'],
          'imp_trib'=>$data['ImpTrib'],
          'mon_id'=>$data['MonId'],
          'mon_cotiz'=>$data['MonCotiz'],
          'ivas'=>json_encode($data['Iva'])
        ];
    }

    private function get_iva_type($iva_type){
        switch ($iva_type) {
          case 'RI':
            return "Resp. Inscripto";
          case 'E':
            return "Exento";
          case 'M':
            return "Monotributo";
          default:
            return "Consumidor Final";
        }
    }

    private function check_type($type){
        switch ($type) {
          case 'VENTA':
          case 'VENTACLIENTE':
              return true;
          default:
            return false;
        }
      }
}
