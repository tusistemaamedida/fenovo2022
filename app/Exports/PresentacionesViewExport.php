<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use stdClass;

class PresentacionesViewExport implements FromView
{
    protected $request;

    use Exportable;

    public function view(): View
    {
        $productos = Product::where('unit_package', 'LIKE', '%|%')->where('active', 1)->get();

        $arrPresentaciones = [];
        foreach ($productos as $producto) {
            $presentaciones = explode('|', $producto->unit_package);
            foreach ($presentaciones as $presentacion) {
                $objOPresentacion               = new stdClass();
                $objOPresentacion->cod_fenovo   = $producto->cod_fenovo;
                $objOPresentacion->presentacion = $presentacion;

                array_push($arrPresentaciones, $objOPresentacion);
            }
        }

        $anio      = date('Y', time());
        $mes       = date('m', time());
        $dia       = date('d', time());
        $hora      = date('H', time());
        $min       = date('i', time());
        $registros = str_pad(count($arrPresentaciones), 4, '0', STR_PAD_LEFT);
        $data = $anio . $mes . $dia . $hora . $min . $registros;

        return view('exports.presentaciones', compact('arrPresentaciones', 'data'));
    }
}
