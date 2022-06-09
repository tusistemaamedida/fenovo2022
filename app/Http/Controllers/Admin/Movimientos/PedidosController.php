<?php

namespace App\Http\Controllers\Admin\Movimientos;

use App\Http\Controllers\Controller;
use App\Models\Movement;
use App\Models\MovementProduct;
use App\Models\Pedido;
use App\Models\PedidoProductos;
use App\Models\PedidoEstados;
use App\Models\Product;
use App\Models\OfertaStore;
use App\Models\SessionOferta;
use App\Models\SessionProduct;
use App\Models\Proveedor;
use App\Models\Store;
use App\Repositories\ProductRepository;
use App\Repositories\ProveedorRepository;
use App\Repositories\SessionProductRepository;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\Facades\DataTables;

class PedidosController extends Controller
{
    private $proveedorRepository;
    private $sessionProductRepository;

    public function __construct(ProveedorRepository $proveedorRepository,SessionProductRepository $sessionProductRepository, ProductRepository $productRepository){
        $this->proveedorRepository = $proveedorRepository;
        $this->productRepository   = $productRepository;
        $this->sessionProductRepository = $sessionProductRepository;
    }

    public function index(Request $request){
        if ($request->ajax()) {
            $pedido = Pedido::where('status','PENDING')->with('store')->orderBy('date', 'DESC')->get();

            return Datatables::of($pedido)
                ->addIndexColumn()
                ->addColumn('origen', function ($pedido) {
                    return $pedido->store->description;
                })
                ->editColumn('date', function ($pedido) {
                    return date('d-m-Y', strtotime($pedido->date));
                })
                ->addColumn('items', function ($pedido) {
                    return '<span class="badge badge-primary">' . count($pedido->productos) . '</span>';
                })
                ->addColumn('voucher', function ($pedido) {
                    return  $pedido->voucher_number;
                })
                ->addColumn('edit', function ($pedido) {
                    return '<a href="' . route('preparar.pedido',['id'=>$pedido->id,'nro'=>$pedido->voucher_number]) . '"> <i class="fa fa-share"></i></a>';
                })
                ->addColumn('show', function ($pedido) {
                    return '<a href="' . route('pedidos.show', ['id' => $pedido->id]) . '"> <i class="fa fa-eye"></i> </a>';
                })
                ->rawColumns(['id', 'origen', 'date', 'items', 'voucher', 'show', 'edit', 'borrar'])
                ->make(true);
        }
        return view('admin.movimientos.pedidos.index');
    }

    public function show(Request $request)
    {
        $pedido = Pedido::query()->where('id', $request->id)->with('productos')->first();
        return view('admin.movimientos.pedidos.show', compact('pedido'));
    }

    public function prepararPedido(Request $request){
        try {
            DB::beginTransaction();
            Schema::disableForeignKeyConstraints();
                $id = $request->id;
                $voucher_number = $request->nro;
                $pedido = Pedido::query()->where('id', $id)->where('voucher_number', $voucher_number)->with('productos')->first();
                $pedido->status = 'IN_PREPARATION';
                $pedido->save();
                PedidoEstados::create([
                    'user_id'=> \Auth::user()->id,
                    'pedido_id' => $pedido->id,
                    'fecha'   => now(),
                    'estado' => 'EN PREPARACION',
                ]);

                foreach ($pedido->productos as $ped_producto) {
                    $producto = Product::where('id',$ped_producto->product_id)->with('product_price')->first();
                    $excepcion = false;
                    // busco el producto en session oferta ordenados asc para tomar el primero
                    $session_oferta = SessionOferta::where('fecha_desde', '<=', Carbon::parse(now())->format('Y-m-d'))
                                                    ->where('product_id', $ped_producto->product_id)
                                                    ->orderBy('fecha_hasta', 'ASC')
                                                    ->first();

                    if ($session_oferta) {
                        // si existe una oferta busco si esa oferta es una excepcion
                        $ofertaStore = OfertaStore::where('session_id', $session_oferta->id)->first();

                        if ($ofertaStore) {
                            // si la oferta esta en oferta_store es porque es una excepcion y solo se aplica a la store vinculada
                            $excepcion = true;
                            if ($ofertaStore->store_id == $pedido->from) {
                                // si la store a la que envio esta en la oferta_store aplica la oferta
                                $prices = $session_oferta;
                            } else {
                                // si la store a la que envio NO esta en la oferta_store NO s aplica la oferta
                                $prices = $producto->product_price;
                            }
                        } else {
                            // como existe la oferta y no esta en oferta_store (excepcion) los precios son de la oferta
                            $prices = $session_oferta;
                        }
                    } else {
                        $prices = $producto->product_price;
                    }

                    $sp = SessionProduct::create([
                        'list_id'      => 'TRASLADO_'.$pedido->from.'_'.$voucher_number,
                        'store_id'     => \Auth::user()->store_active,
                        'product_id'   => $ped_producto->product_id,
                        'neto'         => $prices->plist0neto,
                        'unit_price'   => $prices->plist0neto,
                        'cost_fenovo'  => $prices->costfenovo,
                        'tasiva'       => $prices->tasiva,
                        'unit_package' => $ped_producto->unit_package,
                        'unit_type'    => $ped_producto->unit_type,
                        'quantity'     => $ped_producto->bultos,
                        'ibb'          => $producto->iibb,
                        'nro_pedido'   => $voucher_number
                    ]);
                }
            DB::commit();
            Schema::enableForeignKeyConstraints();
            return redirect()->route('salidas.pendiente.show', ['list_id' => $sp->list_id]);
        } catch (\Exception $e) {
            DB::rollback();
            Schema::enableForeignKeyConstraints();
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
}
