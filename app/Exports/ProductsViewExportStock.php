<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\SessionOferta;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use stdClass;

class ProductsViewExportStock implements FromView
{
    protected $request;

    use Exportable;

    public function view(): View
    {
        $productos    = Product::whereActive(1)->get();
        $arrProductos = [];
        $hoy    = Carbon::parse(now())->format('Y-m-d');

        foreach ($productos as $producto) {

            // Buscar si el producto tiene oferta del proveedor           
            $oferta = SessionOferta::whereProductId($producto->id)->select('costfenovo')->where('fecha_desde', '<=', $hoy)->where('fecha_hasta', '>=', $hoy)->first();
            $costo = (!$oferta) ? $producto->product_price->costfenovo : $oferta->costfenovo;

            $objProducto = new stdClass();
            $objProducto->proveedor    = $producto->proveedor->name;
            $objProducto->cod_fenovo   = $producto->cod_fenovo;
            $objProducto->nombre       = $producto->name;
            $objProducto->costo        = round($costo,2);
            $objProducto->unidad       = $producto->unit_type;
            $objProducto->presentacion = (count(explode('|', $producto->unit_package)) > 1) ? 0 : $producto->unit_package;
            $objProducto->stockini     = ($producto->stockInicioSemana()) ? $producto->stockInicioSemana()->balance : 0;
            $objProducto->stockent     = $producto->ingresoSemana();
            $objProducto->stocksal     = $producto->salidaSemana();
            $objProducto->stockfin     = $producto->stockFinSemana();
            array_push($arrProductos, $objProducto);
        }

        return view('exports.productosStock', compact('arrProductos'));
    }
}
