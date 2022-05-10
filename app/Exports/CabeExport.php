<?php

namespace App\Exports;

use App\Models\SessionPrices;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use App\Models\Panamas;
use App\Models\MovementProduct;
use App\Models\Customer;
use App\Models\Store;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use stdClass;

class CabeExport implements FromView {

    use Exportable;


    public function __construct(){}

    public function view(): View{
        $arr_elementos = [];
        $panamas = Panamas::orderBy('orden','ASC')->get();

        foreach ($panamas as $panama) {
            $element         = new stdClass();

            if($panama->tipo == 'PAN'){
                $id_caja = 'PANAMA';
            }else{
                $id_caja = 'FLETE';
            }

            $element->ID_CLI = $panama->pto_vta;
            $element->NOMCLI = $panama->client_name;
            $element->CUICLI = $panama->client_cuit;
            $element->IVACLI = $panama->client_iva_type;
            $element->IDCAJA = $id_caja;
            $element->NROCOM = $panama->orden;
            $element->FECHA  = Carbon::parse($panama->created_at)->format('d/m/Y');
            $element->HORA   = Carbon::parse($panama->created_at)->format('H:i');
            $element->FISCAL = '8889-' . str_pad($panama->orden, 8, '0', STR_PAD_LEFT);;
            $element->NETO_1 = $panama->neto105;
            $element->IVAA_1 = $panama->iva_neto105;
            $element->NETO_2 = $panama->neto21;
            $element->IVAA_2 = $panama->iva_neto21;
            $element->NOGRAV = $panama->totalIibb;
            $element->TOTVTA = $panama->totalConIva;
            $element->PAGEFV = 0;
            $element->PAGTAR = 0;
            $element->PAGCTA = 0;
            $element->COSVTA = $panama->costo_fenovo_total;
            $element->MARBTO = 0;
            $element->DESCTO = 0;
            $element->RECARG = 0;
            $element->TOTFIS = 0;
            $element->TOTFIS = 0;

            array_push($arr_elementos, $element);
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
