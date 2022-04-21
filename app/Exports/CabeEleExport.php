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
use stdClass;

class CabeEleExport implements FromView {
    protected $request;

    public function __construct($request){
        $this->request = $request;
    }

    public function view(): View{
        $arr_elementos = [];
        $invoices = Invoice::whereNotNull('cae')->orderBy('orden','ASC')->get();

        foreach ($invoices as $invoice) {
            $cliente = null;
            $element         = new stdClass();
            $mov = Movement::where('id',$invoice->movement_id)->first();

            if($mov->type == "VENTA"){
                $cliente = Store::where('id',$mov->to)->with('region')->first();
                $element->ID_CLI = 'PVTA_'.str_pad($cliente->cod_fenovo,3,'0',STR_PAD_LEFT);
                $element->NOMCLI = $cliente->razon_social;
                $element->CUICLI = $cliente->cuit;
                $element->IVACLI = $cliente->iva_type;
            }elseif($mov->type == "VENTACLIENTE"){
                $cliente = Customer::where('id',$mov->to)->with('store')->first();
                $element->ID_CLI = 'CLI_'.str_pad($cliente->id,'0',3,STR_PAD_LEFT);
                $element->NOMCLI = $cliente->razon_social;
                $element->CUICLI = $cliente->cuit;
                $element->IVACLI = $cliente->iva_type;
            }else{
                $element->ID_CLI = null;
                $element->NOMCLI = null;
                $element->CUICLI = null;
                $element->IVACLI = null;
            }

            $element->IDCAJA = null;
            $element->NROCOM = $invoice->orden;
            $element->FECHA  = Carbon::parse($invoice->creted_at)->format('d/m/Y');
            $element->HORA   = Carbon::parse($invoice->creted_at)->format('H:i');
            $element->FISCAL = $invoice->voucher_number;
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
        return 0;
    }

    private function getBaseImporteIva($ivas,$type_iva){
        $ivas = json_decode($ivas);
        foreach ($ivas as $iva) {
            if($type_iva == $iva->Id) return $iva->BaseImp;
        }
        return 0;
    }
}