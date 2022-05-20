<?php

namespace App\Http\Controllers\Admin\Movimientos;

use App\Http\Controllers\Controller;
use App\Models\Movement;
use App\Models\MovementProduct;
use App\Models\MovementProductTemp;
use App\Models\MovementTemp;
use App\Models\Product;
use App\Models\Proveedor;
use App\Repositories\ProductRepository;
use App\Repositories\ProveedorRepository;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\Facades\DataTables;

class IngresosController extends Controller
{
    private $proveedorRepository;

    public function __construct(ProveedorRepository $proveedorRepository, ProductRepository $productRepository)
    {
        $this->proveedorRepository = $proveedorRepository;
        $this->productRepository   = $productRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::user()->rol() == 'superadmin' || Auth::user()->rol() == 'admin') {
                $arrTypes = ['COMPRA'];
                $movement = MovementTemp::whereIn('type', $arrTypes)->whereStatus('CREATED')->with('movement_ingreso_products')->orderBy('date', 'DESC')->get();
            } else {
                $arrTypes = ['VENTA', 'TRASLADO'];
                $movement = MovementTemp::where('to', Auth::user()->store_active)->whereIn('type', $arrTypes)->with('movement_ingreso_products')->orderBy('date', 'DESC')->get();
            }
            return Datatables::of($movement)
                ->addIndexColumn()
                ->addColumn('origen', function ($movement) {
                    return $movement->origenData($movement->type);
                })
                ->editColumn('id', function ($movement) {
                    $ruta = 'editData(' . $movement->id . ",'" . route('ingresos.editIngreso') . "')";
                    return '<a href="javascript:void(0)" onclick="' . $ruta . '">' . $movement->id . '</a>';
                })
                ->editColumn('date', function ($movement) {
                    return date('d-m-Y', strtotime($movement->date));
                })
                ->addColumn('items', function ($movement) {
                    return '<span class="badge badge-primary">' . count($movement->movement_ingreso_products) . '</span>';
                })
                ->addColumn('kgrs', function ($movement) {
                    return '<span class="badge badge-primary">' . $movement->totalKgrs() . '</span>';
                })
                ->addColumn('voucher', function ($movement) {
                    return  $movement->voucher_number;
                })
                ->addColumn('edit', function ($movement) {
                    return '<a href="' . route('ingresos.edit', ['id' => $movement->id]) . '"> <i class="fa fa-pencil-alt"></i></a>';
                })
                ->addColumn('show', function ($movement) {
                    return '<a href="' . route('ingresos.show', ['id' => $movement->id, 'is_cerrada' => false]) . '"> <i class="fa fa-eye"></i> </a>';
                })
                ->rawColumns(['id', 'origen', 'date', 'items', 'kgrs', 'voucher', 'show', 'edit'])
                ->make(true);
        }
        return view('admin.movimientos.ingresos.index');
    }

    public function indexCerradas(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::user()->rol() == 'superadmin' || Auth::user()->rol() == 'admin') {
                $arrTypes = ['COMPRA'];
                $movement = Movement::whereIn('type', $arrTypes)->whereStatus('FINISHED')->with('movement_ingreso_products')->orderBy('id', 'DESC')->orderBy('date', 'DESC')->get();
            } else {
                $arrTypes = ['VENTA', 'TRASLADO'];
                $movement = Movement::where('to', Auth::user()->store_active)->whereIn('type', $arrTypes)->with('movement_ingreso_products')->orderBy('id', 'DESC')->orderBy('date', 'DESC')->get();
            }
            return Datatables::of($movement)
                ->addIndexColumn()
                ->addColumn('origen', function ($movement) {
                    return $movement->origenData($movement->type);
                })
                ->editColumn('date', function ($movement) {
                    return date('d-m-Y', strtotime($movement->date));
                })
                ->addColumn('items', function ($movement) {
                    return '<span class="badge badge-primary">' . $movement->cantidad_ingresos() . '</span>';
                })
                ->addColumn('kgrs', function ($movement) {
                    return '<span class="badge badge-primary">' . $movement->totalKgrs() . '</span>';
                })
                ->addColumn('voucher', function ($movement) {
                    return  $movement->voucher_number;
                })
                ->addColumn('show', function ($movement) {
                    return '<a href="' . route('ingresos.show', ['id' => $movement->id, 'is_cerrada' => true]) . '"> <i class="fa fa-eye"></i> </a>';
                })
                ->rawColumns(['origen', 'date', 'items', 'kgrs', 'voucher', 'show'])
                ->make(true);
        }
        return view('admin.movimientos.ingresos.indexCerradas');
    }

    public function add()
    {
        $proveedores = Proveedor::orderBy('name')->pluck('name', 'id');
        return view('admin.movimientos.ingresos.add', compact('proveedores'));
    }

    public function store(Request $request)
    {
        $data     = $request->all();
        $movement = MovementTemp::create($data);
        return redirect()->route('ingresos.edit', ['id' => $movement->id]);
    }

    public function edit(Request $request)
    {
        $movement    = MovementTemp::find($request->id);
        $productos   = $this->productRepository->getByProveedorIdPluck($movement->from);
        $proveedor   = Proveedor::find($movement->from);
        $movimientos = MovementProductTemp::where('movement_id', $request->id)->orderBy('created_at', 'asc')->get();
        return view('admin.movimientos.ingresos.edit', compact('movement', 'proveedor', 'productos', 'movimientos'));
    }

    public function editIngreso(Request $request)
    {
        try {
            $movement  = MovementTemp::find($request->id);
            $proveedor = Proveedor::find($movement->from);
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.movimientos.ingresos.insertByAjaxIngreso', compact('movement', 'proveedor'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function updateIngreso(Request $request)
    {
        try {
            MovementTemp::find($request->movement_id)->update($request->all());
            return new JsonResponse(['msj' => 'Actualización correcta !', 'type' => 'success']);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function editProduct(Request $request)
    {
        try {
            $product      = Product::find($request->id);
            $unit_package = explode('|', $product->unit_package);
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.movimientos.ingresos.insertByAjax', compact('product', 'unit_package'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function updateProduct(Request $request)
    {
        try {
            $data['unit_package'] = implode('|', $request->unit_package);
            $data['unit_weight']  = $request->unit_weight;
            Product::find($request->product_id)->update($data);
            return new JsonResponse(['msj' => 'Actualización correcta !', 'type' => 'success']);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function close(Request $request)
    {
        try {
            DB::beginTransaction();
            Schema::disableForeignKeyConstraints();

            // Obtengo los datos del movimiento
            $movement_temp = MovementTemp::where('id', $request->id)->with('movement_ingreso_products')->first();

            // Actualizo como finalizado el Movimiento temporal
            MovementTemp::find($request->id)->update(['status' => 'FINISHED']);

            $to    = Auth::user()->store_active;
            $count = Movement::where('to', $to)->where('type', 'COMPRA')->count();
            $orden = ($count) ? $count + 1 : 1;

            // Guardo el nuevo movimiento
            $data['type']           = 'COMPRA';
            $data['to']             = $to;
            $data['date']           = $movement_temp->date;
            $data['from']           = $movement_temp->from;
            $data['orden']          = $orden;
            $data['status']         = 'FINISHED';
            $data['voucher_number'] = $movement_temp->voucher_number;
            $data['flete']          = $movement_temp->flete;
            $data['observacion']    = $movement_temp->observacion;
            $data['user_id']        = \Auth::user()->id;
            $data['flete_invoice']  = 0;
            $movement_new           = Movement::create($data);

            $hoy = Carbon::parse(now())->format('Y-m-d');

            // Recorro el arreglo y voy guardando
            foreach ($movement_temp->movement_ingreso_products as $movimiento) {
                $product               = Product::find($movimiento['product_id']);
                $latest                = $product->stockReal(null, Auth::user()->store_active);
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

                MovementProduct::create([
                    'entidad_id'   => Auth::user()->store_active,
                    'movement_id'  => $movement_new->id,
                    'entidad_tipo' => 'S',
                    'product_id'   => $movimiento['product_id'],
                    'unit_package' => $movimiento['unit_package'],
                    'unit_type'    => $movimiento['unit_type'],
                    'tasiva'       => $product->product_price->tasiva,
                    'cost_fenovo'  => $costo_fenovo,
                    'bultos'       => $movimiento['bultos'],
                    'entry'        => $movimiento['entry'],
                    'egress'       => $movimiento['egress'],
                    'balance'      => $movimiento['balance'],
                ]);
            }

            DB::commit();
            Schema::enableForeignKeyConstraints();

            return redirect()->route('ingresos.indexCerradas');
        } catch (\Exception $e) {
            DB::rollback();
            Schema::enableForeignKeyConstraints();
            dd($e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function show(Request $request)
    {
        $movement = (!$request->is_cerrada)
            ? MovementTemp::query()->where('id', $request->id)->with('movement_ingreso_products')->first()
            : Movement::query()->where('id', $request->id)->with('movement_ingreso_products')->first();

        $movimientos = $movement->movement_ingreso_products;

        return view('admin.movimientos.ingresos.show', compact('movement', 'movimientos'));
    }

    public function destroy(Request $request)
    {
        Movement::find($request->id)->update(['status' => 'CANCELED']);
        return new JsonResponse(
            [
                'msj'  => 'Eliminado ... ',
                'type' => 'success',
            ]
        );
    }

    public function destroyTemp(Request $request)
    {
        MovementTemp::find($request->id)->delete();
        return new JsonResponse(
            ['msj'     => 'Eliminado ... ',
                'type' => 'success', ]
        );
    }

    public function getProveedorIngreso(Request $request)
    {
        $term        = $request->term ?: '';
        $valid_names = [];

        $proveedors = $this->proveedorRepository->search($term);
        foreach ($proveedors as $proveedor) {
            $valid_names[] = ['id' => $proveedor->id, 'text' => $proveedor->displayName()];
        }

        return new JsonResponse($valid_names);
    }
}
