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
        $movimientos = Movement::where('type','VENTA')->orWhere('type','VENTACLIENTE')->orderBy('created_at','DESC')->limit(150)->get();

        foreach ($movimientos as $mov) {
            $cliente = null;
            $element         = new stdClass();

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
            $element->NROCOM = $mov->orden;
            $element->FECHA  = Carbon::parse($mov->created_at)->format('d/m/Y');
            $element->HORA   = Carbon::parse($mov->created_at)->format('H:i');
            $element->FISCAL = null;
            $element->NETO_1 = (is_null($mov->neto105($this->invoice)) || is_null($mov->neto105($this->invoice)->neto105))?0:$mov->neto105($this->invoice)->neto105;
            $element->IVAA_1 = (is_null($mov->neto105($this->invoice)) || is_null($mov->neto105($this->invoice)->neto_iva105))?0:$mov->neto105($this->invoice)->neto_iva105;
            $element->NETO_2 = (is_null($mov->neto21($this->invoice)) || is_null($mov->neto21($this->invoice)->neto21))?0:$mov->neto21($this->invoice)->neto21;
            $element->IVAA_2 = (is_null($mov->neto21($this->invoice)) || is_null($mov->neto21($this->invoice)->neto_iva21))?0:$mov->neto21($this->invoice)->neto_iva21;
            $element->NOGRAV = (is_null($mov->totalIibb($this->invoice)) || is_null($mov->totalIibb($this->invoice)->total_no_gravado))?0:$mov->totalIibb($this->invoice)->total_no_gravado;
            $element->TOTVTA = (is_null($mov->totalConIva($this->invoice)) || is_null($mov->totalConIva($this->invoice)->totalConIva))?0:$mov->totalConIva($this->invoice)->totalConIva;
            $element->PAGEFV = 0;
            $element->PAGTAR = 0;
            $element->PAGCTA = 0;
            $element->COSVTA = (is_null($mov->cosventa($this->invoice)) || is_null($mov->cosventa($this->invoice)->cost_venta))?0:$mov->cosventa($this->invoice)->cost_venta;
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
}
