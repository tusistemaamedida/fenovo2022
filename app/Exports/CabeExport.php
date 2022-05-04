<?php

namespace App\Exports;

use App\Models\SessionPrices;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use App\Models\Movement;
use App\Models\MovementProduct;
use App\Models\Customer;
use App\Models\Store;
use Carbon\Carbon;
use stdClass;

class CabeExport implements FromView {
    protected $request;
    protected $invoice;

    public function __construct($request,$invoice){
        $this->request = $request;
        $this->invoice = $invoice;
    }

    public function view(): View{
        $arr_elementos = [];
        $movimientos = Movement::where('type','VENTA')->orWhere('type','VENTACLIENTE')->orderBy('created_at','ASC')->get();

        foreach ($movimientos as $mov) {
            if(count($mov->panamas)){
                $cliente = null;
                $element         = new stdClass();

                if($mov->type == "VENTA"){
                    $cliente = Store::where('id',$mov->to)->with('region')->first();
                    $element->ID_CLI = 'PVTA_'.str_pad($cliente->cod_fenovo,3,'0.0',STR_PAD_LEFT);
                }elseif($mov->type == "VENTACLIENTE"){
                    $cliente = Customer::where('id',$mov->to)->with('store')->first();
                    $element->ID_CLI = 'CLI_'.str_pad($cliente->id,'0.0',3,STR_PAD_LEFT);
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
                $element->NROCOM = $mov->orden;
                $element->FECHA  = Carbon::parse($mov->created_at)->format('d/m/Y');
                $element->HORA   = Carbon::parse($mov->created_at)->format('H:i');
                $element->FISCAL = null;
                $element->NETO_1 = (is_null($mov->neto105($this->invoice)) || is_null($mov->neto105($this->invoice)->neto105))?'0.0':$mov->neto105($this->invoice)->neto105;
                $element->IVAA_1 = (is_null($mov->neto105($this->invoice)) || is_null($mov->neto105($this->invoice)->neto_iva105))?'0.0':$mov->neto105($this->invoice)->neto_iva105;
                $element->NETO_2 = (is_null($mov->neto21($this->invoice)) || is_null($mov->neto21($this->invoice)->neto21))?'0.0':$mov->neto21($this->invoice)->neto21;
                $element->IVAA_2 = (is_null($mov->neto21($this->invoice)) || is_null($mov->neto21($this->invoice)->neto_iva21))?'0.0':$mov->neto21($this->invoice)->neto_iva21;
                $element->NOGRAV = (is_null($mov->totalIibb($this->invoice)) || is_null($mov->totalIibb($this->invoice)->total_no_gravado))?'0.0':$mov->totalIibb($this->invoice)->total_no_gravado;
                $element->TOTVTA = (is_null($mov->totalConIva($this->invoice)) || is_null($mov->totalConIva($this->invoice)->totalConIva))?'0.0':$mov->totalConIva($this->invoice)->totalConIva;
                $element->PAGEFV = 0;
                $element->PAGTAR = 0;
                $element->PAGCTA = 0;
                $element->COSVTA = (is_null($mov->cosventa($this->invoice)) || is_null($mov->cosventa($this->invoice)->cost_venta))?'0.0':$mov->cosventa($this->invoice)->cost_venta;
                $element->MARBTO = 0;
                $element->DESCTO = 0;
                $element->RECARG = 0;
                $element->TOTFIS = 0;


                array_push($arr_elementos, $element);
            }
        }

        $anio      = date('Y', time());
        $mes       = date('m', time());
        $dia       = date('d', time());
        $hora      = date('H', time());
        $min       = date('i', time());
        $registros = str_pad(count($arr_elementos), 4, '0.0', STR_PAD_LEFT);

        $data = $anio . $mes . $dia . $hora . $min . $registros;

        return view('exports.cabePed', compact('arr_elementos','data'));
    }
}
