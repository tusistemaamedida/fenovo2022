<?php

namespace App\Http\Controllers\Admin\Movimientos;

use App\Http\Controllers\Controller;
use App\Models\MovementProduct;
use App\Models\Product;
use App\Models\SessionOferta;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DetalleIngresosController extends Controller
{
    public function store(Request $request)
    {
        try {
            $hoy = Carbon::parse(now())->format('Y-m-d');

            foreach ($request->datos as $movimiento) {

                $product               = Product::find($movimiento['product_id']);
                $latest                = $product->stock(null, Auth::user()->store_active);
                $balance               = ($latest) ? $latest + $movimiento['entry'] : $movimiento['entry'];
                $movimiento['balance'] = $balance;

                // Buscar si el producto tiene oferta del proveedor
                $oferta = DB::table('products as t1')
                    ->join('session_ofertas as t2', 't1.id', '=', 't2.product_id')
                    ->select('t2.costfenovo')
                    ->where('t1.id', $movimiento['product_id'])
                    ->where('t2.fecha_desde', '<=', $hoy)
                    ->where('t2.fecha_hasta', '>=', $hoy)
                    ->first();
                $costo_fenovo = (!$oferta) ? $product->product_price->costfenovo : $oferta->costfenovo;

                MovementProduct::firstOrCreate(
                    ['entidad_id'      => Auth::user()->store_active,
                        'movement_id'  => $movimiento['movement_id'],
                        'product_id'   => $movimiento['product_id'],
                        'tasiva'       => $product->product_price->tasiva,
                        'cost_fenovo'  => $costo_fenovo,
                        'unit_package' => $movimiento['unit_package'], ],
                    $movimiento
                );
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
