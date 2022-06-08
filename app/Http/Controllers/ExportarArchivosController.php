<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\SessionPrices;
use App\Models\Invoice;
use App\Models\Movement;
use App\Models\MovementProduct;
use App\Models\Customer;
use App\Models\Store;
use Carbon\Carbon;
use stdClass;

class ExportarArchivosController extends Controller
{
    public function exportIIBB(Request $request){
        $arr_elementos = [];
        $invoices = Invoice::whereNotNull('cae')->where('jurisdiccion',908)->with('tipoFactura')->orderBy('created_at','ASC')->orderBy('voucher_number','ASC')->get();
        $i=1;
        $dataTxt = '';

        foreach ($invoices as $invoice) {
            $nro = str_pad($i, 5, 0, STR_PAD_LEFT);
            $tipo_comprobante = str_pad($invoice->tipoFactura->afip_id, 3, 0, STR_PAD_LEFT);
            $letra = 'A';
            $explodes = explode('-',$invoice->voucher_number);
            $ptoVta = str_pad((int)$explodes[0], 4, "0", STR_PAD_LEFT);
            $nro_comprobante = $ptoVta.$explodes[1];
            $cuit = $invoice->client_cuit;
            $fecha = Carbon::parse($invoice->created_at)->format('d/m/Y');
            $monto = $invoice->imp_neto;
            $alicuota = '003.00';
            $percibido = $this->getTributoIva($invoice->tributos);
            $regimen = 004 ;
            $jurisdiccion = 908;
            if((int)$percibido > 0 ){
                $dataTxt .= $nro.','.$tipo_comprobante.','.$letra.','.$nro_comprobante.','.$cuit.','.$fecha.','.$monto.','.$alicuota.','.$percibido.','.$regimen.','.$jurisdiccion.PHP_EOL;
                $i++;
            }
        }

        $file = "exportacion/iibb.txt";
        $txtFile = fopen(public_path($file), "w");
        fwrite($txtFile, $dataTxt . PHP_EOL);
        fclose($txtFile);

        return response()->download(public_path($file));
    }

    private function getImporteIva($ivas,$type_iva){
        $ivas = json_decode($ivas);
        foreach ($ivas as $iva) {
            if($type_iva == $iva->Id){
                if($type_iva == 4){
                    $iva = ($iva->BaseImp * 10.5)/100;
                    return round($iva,2);
                }

                if($type_iva == 5){
                    $iva = ($iva->BaseImp * 21)/100;
                    return round($iva,2);
                }
            }
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

    private function getTributoNeto($tributos){
        if(!is_null($tributos)){
            $t = json_decode($tributos);
            if(count($t)){
                return $t[0]->BaseImp;
            }
        }
        return '0.0';
    }

    private function getTributoIva($tributos){
        if(!is_null($tributos)){
            $t = json_decode($tributos);
            if(count($t)){
                return $t[0]->Importe;
            }
        }
        return 0;
    }
}
