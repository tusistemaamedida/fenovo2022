<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\InvoicesRepository;
use App\Models\Movement;
use App\Models\Invoice;
use App\Models\MovementProduct;
use App\Models\Store;
use App\Models\Customer;
use App\Models\VoucherType;
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

    public function generateInvoicePdf($movement_id){
        $titulo = 'FACTURA ELECTRÓNICA';
        $array_productos = $alicuotas_array = [];
        $invoice = $this->invoiceRepository->getByMovement($movement_id);
        if(!is_null($invoice->cae)){
            $movement = Movement::where('id',$movement_id)->firstOrFail();
            if($movement->type == 'DEVOLUCION' || $movement->type == 'DEVOLUCIONCLIENTE') $titulo = 'NOTA CRÉDITO';
            $productos = MovementProduct::where('movement_id',$movement_id)->where('invoice',1)->where('egress', '>', 0)->with('product')->get();
            foreach ($productos as $producto) {
                $objProduct = new stdClass;
                $objProduct->cant = $producto->bultos * $producto->unit_package;
                $objProduct->iva = number_format($producto->tasiva, 2, ',', '.');
                $objProduct->unit_price = $producto->unit_price;
                $objProduct->total = number_format($producto->bultos * $producto->unit_price * $producto->unit_package, 2, ',', '.');
                $objProduct->name = $producto->product->name;
                $objProduct->unity = $producto->product->unit_type;
                $objProduct->class = '';
                array_push($array_productos,$objProduct);
            }

            if(!is_null($movement->flete ) && $movement->flete > 0 && $movement->flete_invoice){
                $objProduct = new stdClass;
                $objProduct->cant = 1;
                $objProduct->iva = 21;
                $objProduct->unit_price = $movement->flete;
                $objProduct->total = number_format($movement->flete, 2, ',', '.');
                $objProduct->name = 'FLETE';
                $objProduct->unity = ' ';
                $objProduct->class = '';
                array_push($array_productos,$objProduct);
            }

            $total_lineas = 22;
            $paginas = (int) ((count($array_productos)/$total_lineas) + 1);
            $faltantes_para_completar = ($total_lineas * $paginas) - count($array_productos);

            for ($aux = 0; $aux < $faltantes_para_completar; $aux++) {
                $objProduct = new stdClass;
                $objProduct->cant = 0;
                $objProduct->iva = 'none';
                $objProduct->name = 'none';
                $objProduct->total = 'none';
                $objProduct->unit_price = 0;
                $objProduct->unity = 'none';
                $objProduct->class = 'no-visible';
                array_push($array_productos,$objProduct);
              }

            $alicuotas = json_decode($invoice->ivas);
            foreach ($alicuotas as $alicuota) {
                $objAlicuota = new stdClass;
                $objAlicuota->name = $this->get_alicuota_value($alicuota->Id);
                $objAlicuota->value = number_format($alicuota->Importe, 2, ',', '.') ;
                array_push($alicuotas_array,$objAlicuota);
            }
            if(!\File::exists(public_path('images'))) {
                \File::makeDirectory(public_path('images'), $mode = 0777, true, true);
            }

            \QrCode::generate(url('factura-electronica/'.$movement_id), 'images/'.$invoice->voucher_number.'.svg');

            $qr_url = 'images/'.$invoice->voucher_number.'.svg';
            $voucherType = VoucherType::where('afip_id',$invoice->cbte_tipo)->first();
            $pdf = PDF::loadView('print.invoice',compact('titulo','invoice','array_productos','alicuotas_array','voucherType','qr_url','paginas','total_lineas'));
            return $pdf->stream('invoice.pdf');
        }
    }

    public function create($movement_id){
        try {
            $movement = Movement::where('id',$movement_id)->with('movement_salida_products')->firstOrFail();

            $result = $this->createVoucher($movement);
            $invoice = $this->invoiceRepository->getByMovement($movement_id);
            if($result['status']){
                if(isset($invoice)){
                    $count = Invoice::whereNotNull('cae')->count();
                    $orden = ($count)?$count+1:1;
                    $this->invoiceRepository->fill($invoice->id,[
                        'error' => null,
                        'orden' => $orden,
                        'cae' => $result['response_afip']['CAE'],
                        'expiration' => $result['response_afip']['CAEFchVto']
                    ]);
                }

                return redirect()->back()->withInput();
            }else{
                if(isset($invoice)) $this->invoiceRepository->fill($invoice->id,[ 'error' => $result['error'] ]);
                return $result['error'];
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    private function get_alicuota_value($iva_id){
        switch ($iva_id) {
          case 6:
            return '27%';
          case 5:
            return "21%";
          case 4:
            return "10,5%";
          case 8:
            return "5%";
          case 9:
            return "2,5%";
          case 3:
            return "0%";
          default:
            return "0%";
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
              $more_data->costo_fenovo_total =  $data_invoice['costo_fenovo_total'];

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

        return ['status' => false,  'error' => $data_invoice['error']];
    }

    private function dataInvoice($movement){
        try {
            $tipo_movimiento = $movement->type;
            $client = $this->dataClient($tipo_movimiento,(int)$movement->to);

            if($client){
                $last_voucher = 0;
                $fecha_servicio_desde = $fecha_servicio_hasta = $fecha_vencimiento_pago = 0;
                $concepto = $this->concepto_afip;
                $punto_de_venta = $this->pto_vta;
                $tipo_de_factura = $this->voucherType($this->client->iva_type,$tipo_movimiento);
                $tipo_de_documento = $this->document_type;
                $numero_de_documento = $this->client->cuit;
                $last_voucher = $this->afip->ElectronicBilling->GetLastVoucher($punto_de_venta, $tipo_de_factura);

                $numero_de_factura = $last_voucher+1;
                $fecha = date('Y-m-d');
                $iibb = Iibb::where('state',$this->client->state)->first();
                $iibb = ($iibb)?$iibb->value:0;

                $importe = $this->importes($movement);
                $importe_gravado = $importe['gravado'];
                $importe_total_iibb = $importe['total_iibb'];
                $importe_exento_iva = 0;
                $importe_iva = $importe['iva'];

                $importe_no_gravado = ($iibb>0)?($importe_total_iibb * $iibb /100):0;

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

                if($tipo_movimiento == 'DEVOLUCION' || $tipo_movimiento == 'DEVOLUCIONCLIENTE'){
                    $invoice = $this->invoiceRepository->getByVoucherNumber($movement->voucher_number);
                    if($invoice){
                        $explode = explode('-',$movement->voucher_number);
                        $dataAfip['CbtesAsoc'] = array( //Factura asociada
                            array(
                                'Tipo' 		=> $invoice->cbte_tipo,
                                'PtoVta' 	=> $invoice->pto_vta,
                                'Nro' 		=> (int)$explode[1],
                            )
                        );
                    }
                }

                return [
                    'status'=> true,
                    'data' => $dataAfip ,
                    'client' => $this->client,
                    'numero_de_factura' => $numero_de_factura,
                    'iibb' => $iibb,
                    'costo_fenovo_total' => $importe['costo_fenovo_total']
                ];
            }
            return ['status' => false, 'error' => "Cliente o store no encontrado en el movimiento ". $movement->id];
        } catch (\Exception $e) {
          return ['status' => false, 'error' => $e->getMessage()];
        }
    }

    private function importes($movement){
        $products = $movement->movement_salida_products;
        $gravado = 0;
        $costo_fenovo_total = 0;
        $iva = 0;
        $total_iibb = 0;
        $ivas = [];

        foreach ($products as $product) {
            if($product->invoice && $product->egress > 0){
                $obj_iva = new stdClass;
                $tasiva = $product->tasiva;
                $subtotal = $product->bultos * $product->unit_price * $product->unit_package; // cantidad de salida por el precio del producto
                $iva_price = ($subtotal * $tasiva)/100; // iva del subtotal del precio

                if($product->iibb) $total_iibb += $subtotal;
                $gravado += $subtotal;
                $iva += $iva_price;
                $costo_fenovo_total += $product->cost_fenovo;

                $id_alicuota = $this->get_alicuota_id($tasiva);

                $BaseImp = round($subtotal,2);
                $Importe = round($iva_price,2);

                $obj_iva->Id = $id_alicuota;
                $obj_iva->BaseImp = $BaseImp;
                $obj_iva->Importe = $Importe;
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
        //dd(['gravado' => round($gravado,2), 'iva' => round($iva,2), 'ivas' => $ivas]);
        if(!is_null($movement->flete) && $movement->flete > 0 && $movement->flete_invoice){
            $insert_new = true;
            $iva        += ($movement->flete * 0.21);
            $gravado    += $movement->flete;
            $total_iibb += $movement->flete;

            for ($cont=0; $cont <count($ivas) ; $cont++) {
                $alicuota = $ivas[$cont];
                if($alicuota->Id == 5){
                    $alicuota->BaseImp = round(($alicuota->BaseImp + $movement->flete),2);
                    $alicuota->Importe = round(($alicuota->Importe + $movement->flete * 0.21),2);
                    $insert_new = false;
                }
            }
            if($insert_new){
                $obj_iva = new stdClass;
                $obj_iva->Id = 5;
                $obj_iva->BaseImp = round(($movement->flete),2);
                $obj_iva->Importe = round(($movement->flete * 0.21),2);
                array_push($ivas,$obj_iva);
            }
        }
        //dd(['gravado' => round($gravado,2), 'iva' => round($iva,2), 'ivas' => $ivas]);
        return [
            'gravado' => round($gravado,2),
            'iva' => round($iva,2),
            'ivas' => $ivas,
            'total_iibb' => $total_iibb,
            'costo_fenovo_total' => $costo_fenovo_total
        ];
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
          case 'DEVOLUCION':
            $this->client = Store::where('id',$id)->where('active', 1)->with('region')->first();
            return true;
          case 'VENTACLIENTE':
          case 'DEVOLUCIONCLIENTE':
            $this->client = Customer::where('id',$id)->where('active', 1)->with('store')->first();
            return true;
          default:
            return false;
        }
    }

    private function voucherType($type,$tipo_movimiento){
        $factura = 6; //Por defecto FACTURA B
        if(($type == 'RI' && $tipo_movimiento == 'VENTA') || $type == 'RI' && $tipo_movimiento == 'VENTACLIENTE') $factura = 1; //FACTURA A
        if(($type != 'RI' && $tipo_movimiento == 'VENTA') || $type != 'RI' && $tipo_movimiento == 'VENTACLIENTE') $factura = 6; //FACTURA B
        if(($type == 'RI' && $tipo_movimiento == 'DEVOLUCION') || $type == 'RI' && $tipo_movimiento == 'DEVOLUCIONCLIENTE') $factura = 3; //NOTA CREDITO A
        if(($type != 'RI' && $tipo_movimiento == 'DEVOLUCION') || $type != 'RI' && $tipo_movimiento == 'DEVOLUCIONCLIENTE') $factura = 8; //NOTA CREDITO B

        return $factura;
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
            case 'DEVOLUCION':
            case 'DEVOLUCIONCLIENTE':
              return true;
          default:
            return false;
        }
      }
}
