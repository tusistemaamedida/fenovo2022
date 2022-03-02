<?php

namespace App\Http\Controllers\Admin\Movimientos;

use App\Http\Controllers\Controller;
use App\Models\MovementProduct;
use App\Models\Product;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetalleIngresosController extends Controller
{
    public function store(Request $request)
    {
        try {
            foreach ($request->datos as $movimiento) {
                $product               = Product::find($movimiento['product_id']);
                $latest                = $product->stock(null, Auth::user()->store_active);
                $balance               = ($latest) ? $latest + $movimiento['entry'] : $movimiento['entry'];
                $movimiento['balance'] = $balance;
                MovementProduct::firstOrCreate(['store_id' => Auth::user()->store_active, 'movement_id' => $movimiento['movement_id'], 'product_id' => $movimiento['product_id'], 'unit_package' => $movimiento['unit_package']], $movimiento);
            }

            return new JsonResponse(['msj' => 'Guardado', 'type' => 'success']);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function check(Request $request)
    {
        try {
            $productId      = $request->productId;
            $producto       = Product::find($productId);
            $presentaciones = explode('|', $producto->unit_package);
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.movimientos.ingresos.detalleTemp', compact('producto', 'presentaciones'))->render(),

            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function destroy(Request $request)
    {
        try {
            MovementProduct::where('movement_id', $request->movement_id)->where('product_id', $request->product_id)->delete();
            $movimientos = MovementProduct::where('movement_id', $request->movement_id)->orderBy('id', 'desc')->get();
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.movimientos.ingresos.detalleConfirm', compact('movimientos'))->render(),
            ]);
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.movimientos.ingresos.detalleTemp', compact('producto', 'presentaciones'))->render(),

            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }
}
