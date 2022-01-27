<?php

namespace App\Http\Controllers\Admin\Movimientos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Models\MovementProduct;
use App\Models\Product;
use App\Repositories\ProductRepository;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class DetalleIngresosController extends Controller
{
    public function store(Request $request)
    {
        try {
            foreach ($request->datos as $movimiento) {
                $latest = MovementProduct::all()->where('store_id', 1)->where('product_id', $movimiento['product_id'])->sortByDesc('id')->first();
                $balance = ($latest) ? $latest->balance + $movimiento['entry'] : $movimiento['entry'];
                $movimiento['balance'] = $balance;
                MovementProduct::firstOrCreate(['store_id' => 1, 'movement_id' => $movimiento['movement_id'], 'product_id' => $movimiento['product_id'], 'unit_package' => $movimiento['unit_package'],], $movimiento);
            }

            return new JsonResponse(['msj' => 'Guardado', 'type' => 'success']);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function check(Request $request)
    {
        try {
            $productId = $request->productId;
            $producto       = Product::find($productId);
            $presentaciones = explode(',', $producto->unit_package);
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.movimientos.ingresos.detalleTemp', compact('producto', 'presentaciones'))->render()

            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }
}
