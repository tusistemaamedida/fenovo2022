<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SessionOferta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use stdClass;

class ProductoController extends Controller
{
    public function getProductos(Request $request)
    {
        $txtProducto = $request->txtProducto;

        $productos = DB::table('products as t1')->where('t1.active',1)
            ->join('product_prices as t2', 't1.id', '=', 't2.product_id')
            ->join('proveedors as t3', 't3.id', '=', 't1.proveedor_id')
            ->select(['t1.id', 't1.cod_fenovo', 't1.name', 't1.unit_type', 't2.costfenovo', 't3.name as proveedor'])
            ->selectRaw('CONCAT(t1.cod_fenovo," ", t1.name," ", t3.name) as txtProducto')
            ->having('txtProducto', 'LIKE', "%$txtProducto%")
            ->orderBy('t1.cod_fenovo', 'ASC')
            ->get(10);                    

        $arrProductos = [];

        foreach ($productos as $producto) {
            $objProducto             = new stdClass();

            $objProducto->id         = $producto->id;
            $objProducto->cod_fenovo = $producto->cod_fenovo;
            $objProducto->name       = $producto->name;
            $objProducto->stock      = Product::find($producto->id)->stockReal(null, 1);
            $objProducto->unit_type  = $producto->unit_type;
            $objProducto->proveedor  = $producto->proveedor;
            $objProducto->costfenovo = $producto->costfenovo;

            // Ofertas
            $oferta            = SessionOferta::doesntHave('stores')->select('id')->whereProductId($producto->id)->first();
            $objProducto->linkOferta = ($oferta)
                ? route('product.edit', ['id' => $producto->id, 'oferta_id' => $oferta->id, 'fecha_oferta' => $oferta->id]) . '#precios'
                : route('product.edit', ['id' => $producto->id]);
                
            // Borrar
            $objProducto->linkBorrar = route('product.destroy', ['id' => $producto->id]);
                
            // Historial
            $objProducto->linkHistorial = route('product.historial', ['id' => $producto->id]);

            array_push($arrProductos, $objProducto);
        }

        $data = $this->paginate($arrProductos, 20);

        return $data;
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
