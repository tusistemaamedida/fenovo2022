<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use stdClass;

class PresentacionesViewExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

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

        return view('exports.presentaciones', compact('arrPresentaciones'));
    }
}
