<?php

namespace App\Exports;

use App\Models\SessionPrices;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use App\Models\Invoice;
use App\Models\Movement;
use App\Models\MovementProduct;
use App\Models\Customer;
use App\Models\Store;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use stdClass;

class CabeEleExport implements FromView {

    use Exportable;

    public function __construct(){ }

    public function view(): View{
        $arr_elementos = [];
        $invoices = Invoice::whereNotNull('cae')->with('tipoFactura')->orderBy('created_at','ASC')->orderBy('voucher_number','ASC')->get();
        $i=1;
        foreach ($invoices as $invoice) {
            $cliente = null;
            $element         = new stdClass();
            $mov = Movement::where('id',$invoice->movement_id)->first();

            if($mov->type == "VENTA" || $mov->type == "DEVOLUCION"){
                $cliente = Store::where('id',$mov->to)->with('region')->first();
                $element->ID_CLI = 'PVTA_'.str_pad($cliente->cod_fenovo,3,'0',STR_PAD_LEFT);
            }elseif($mov->type == "VENTACLIENTE"){
                $cliente = Customer::where('id',$mov->to)->with('store')->first();
                $element->ID_CLI = 'CLI_'.str_pad($cliente->id,'0',3,STR_PAD_LEFT);
            }else{
                $element->ID_CLI = null;
                $element->NOMCLI = null;
                $element->CUICLI = null;
                $element->IVACLI = null;
            }

            if(isset($cliente ) && !is_null($cliente)){
                $cuit1 = substr($cliente->cuit,0,2);
                $cuit2 = substr($cliente->cuit,2,8);
                $cuit3 = substr($cliente->cuit,10,1);
                $cuit  = $cuit1.'-'.$cuit2.'-'.$cuit3;
                $element->NOMCLI = $cliente->razon_social;
                $element->CUICLI = $cuit;
                $element->IVACLI = ($cliente->iva_type == 'RI')?'I':$cliente->iva_type;
            }

            $element->IDCAJA = null;
            $element->NROCOM = $invoice->orden;
            $element->FECHA  = Carbon::parse($invoice->created_at)->format('d/m/Y');
            $element->HORA   = Carbon::parse($invoice->created_at)->format('H:i');

            if($invoice->tipoFactura->afip_id == 3){
                $tipo_factura = 'NCA';
            }elseif($invoice->tipoFactura->afip_id == 1){
                $tipo_factura = 'FCA';
            }elseif($invoice->tipoFactura->afip_id == 2){
                $tipo_factura = 'NDA';
            }
            $explodes = explode('-',$invoice->voucher_number);
            $ptoVta = str_pad((int)$explodes[0], 4, "0", STR_PAD_LEFT);
            //str_pad($this->pto_vta, 4, "0", STR_PAD_LEFT)
            $element->FISCAL = $tipo_factura.$ptoVta.'-'.$explodes[1] ;
            $element->NETO_1 = $this->getBaseImporteIva($invoice->ivas,4); //4 es el 10.5
            $element->IVAA_1 = $this->getImporteIva($invoice->ivas,4); //4 es el 10.5
            $element->NETO_2 = $this->getBaseImporteIva($invoice->ivas,5); //5 es el 21
            $element->IVAA_2 = $this->getImporteIva($invoice->ivas,5); //45 es el 215
            $element->NOGRAV = $invoice->imp_tot_conc;
            $element->TOTVTA = $invoice->imp_total;
            $element->PAGEFV = 0;
            $element->PAGTAR = 0;
            $element->PAGCTA = 0;
            $element->COSVTA = (is_null($invoice->costo_fenovo_total))?0:$invoice->costo_fenovo_total;
            $element->MARBTO = 0;
            $element->DESCTO = 0;
            $element->RECARG = 0;
            $element->TOTFIS = 0;

            //$invoice->orden = $i;
           // $invoice->save();
            //$i++;
            array_push($arr_elementos, $element);
        }

        $anio      = date('Y', time());
        $mes       = date('m', time());
        $dia       = date('d', time());
        $hora      = date('H', time());
        $min       = date('i', time());
        $registros = str_pad(count($arr_elementos), 4, '0', STR_PAD_LEFT);

        $data = $anio . $mes . $dia . $hora . $min . $registros;

        return view('exports.cabePed', compact('arr_elementos','data'));
    }

    private function getImporteIva($ivas,$type_iva){
        $ivas = json_decode($ivas);
        foreach ($ivas as $iva) {
            if($type_iva == $iva->Id) return $iva->Importe;
        }
        return '0.0';
    }

    private function getBaseImporteIva($ivas,$type_iva){
        $ivas = json_decode($ivas);
        foreach ($ivas as $iva) {
            if($type_iva == $iva->Id) return $iva->BaseImp;
        }
        return '0.0';
    }
}
