<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SessionOferta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class ProductoController extends Controller
{
    public function getProductos(Request $request)
    {
        $productos = DB::table('products as t1')
            ->join('product_prices as t2', 't1.id', '=', 't2.product_id')
            ->join('proveedors as t3', 't3.id', '=', 't1.proveedor_id')
            ->select(['t1.id', 't1.cod_fenovo', 't1.name', 't1.unit_type', 'stock_f', 'stock_r', 'stock_cyo', 't2.costfenovo', 't3.name as proveedor'])
            ->where('t1.name', 'like', '%' . $request->name . '%')
            ->orWhere('t1.cod_fenovo', 'like', '%' . $request->codfenovo . '%')
            ->orderBy('t1.id', 'ASC')
            ->limit(10)
            ->get();

        $arrProductos = [];

        foreach ($productos as $producto) {
            $objProducto             = new stdClass();
            $objProducto->cod_fenovo = $producto->cod_fenovo;
            $objProducto->name       = $producto->name;
            $objProducto->unit_type  = $producto->unit_type;
            $objProducto->proveedor  = $producto->proveedor;
            $objProducto->costfenovo = $producto->costfenovo;
            $objProducto->stock      = $producto->stock_f + $producto->stock_r + $producto->stock_cyo;

            // Ofertas
            $oferta            = SessionOferta::doesntHave('stores')->whereProductId($producto->id)->first();
            $objProducto->link = ($oferta)
                ? route('product.edit', ['id' => $producto->id, 'oferta_id' => $oferta->id, 'fecha_oferta' => $oferta->id]) . '#precios'
                : route('product.edit', ['id' => $producto->id]);

            array_push($arrProductos, $objProducto);
        }

        return $arrProductos;
    }
}
