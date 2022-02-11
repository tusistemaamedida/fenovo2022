<?php

namespace App\Http\Controllers\Admin\Movimientos;

use App\Http\Controllers\Controller;
use App\Models\Movement;
use App\Models\MovementProduct;
use App\Models\Product;
use App\Models\Proveedor;
use App\Repositories\ProductRepository;
use App\Repositories\ProveedorRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
            $arrTypes = ['COMPRA'];
            $movement = Movement::all()->whereIn('type', $arrTypes)->sortByDesc('created_at');
            return Datatables::of($movement)
                ->addIndexColumn()
                ->addColumn('origen', function ($movement) {
                    return $movement->origenData($movement->type);
                })
                ->editColumn('date', function ($movement) {
                    return date('Y-m-d', strtotime($movement->date));
                })
                ->editColumn('type', function ($movement) {
                    return $movement->type;
                })
                ->editColumn('updated_at', function ($movement) {
                    return date('Y-m-d H:i:s', strtotime($movement->updated_at));
                })
                ->addColumn('edit', function ($movement) {
                    return ($movement->status == 'CREATED')
                    ? '<a class="dropdown-item" href="' . route('ingresos.edit', ['id' => $movement->id]) . '"> <i class="fa fa-edit text-primary"></i> </a>'
                    : '<a class="dropdown-item" href="' . route('ingresos.show', ['id' => $movement->id]) . '"> <i class="fa fa-eye"></i> </a>';
                })
                ->rawColumns(['origen', 'date', 'type', 'edit'])
                ->make(true);
        }
        return view('admin.movimientos.ingresos.index');
    }

    public function add()
    {
        $proveedores = Proveedor::orderBy('name')->pluck('name', 'id');
        return view('admin.movimientos.ingresos.add', compact('proveedores'));
    }

    public function store(Request $request)
    {
        $movement = Movement::create($request->all());
        return redirect()->route('ingresos.edit', ['id' => $movement->id]);
    }

    public function edit(Request $request)
    {
        $movement    = Movement::find($request->id);
        $productos   = $this->productRepository->getByProveedorIdPluck($movement->from);
        $proveedor   = Proveedor::find($movement->from);
        $movimientos = MovementProduct::where('movement_id', $request->id)->orderBy('created_at', 'asc')->get();
        return view('admin.movimientos.ingresos.edit', compact('movement', 'proveedor', 'productos', 'movimientos'));
    }

    public function editProduct(Request $request)
    {
        try {
            $product      = Product::find($request->id);
            $unit_package = explode(',', $product->unit_package);
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
            $data['unit_package'] = implode(',', $request->unit_package);
            Product::find($request->product_id)->update($data);
            return new JsonResponse(['msj' => 'Actualización correcta !', 'type' => 'success']);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function close(Request $request)
    {
        Movement::find($request->id)->update(['status' => 'FINISHED']);
        return new JsonResponse(
            ['msj'     => 'Cerrado ... ',
                'type' => 'success', ]
        );
    }

    public function show(Request $request)
    {
        $movement    = Movement::find($request->id);
        $proveedor   = Proveedor::find($movement->from);
        $movimientos = MovementProduct::where('movement_id', $request->id)->orderBy('created_at', 'asc')->get();
        return view('admin.movimientos.ingresos.show', compact('movement', 'proveedor', 'movimientos'));
    }

    public function destroy(Request $request)
    {
        Movement::find($request->id)->delete();
        return new JsonResponse(
            ['msj'     => 'Eliminado ... ',
                'type' => 'success', ]
        );
    }

    public function getMovements(Request $request)
    {
        try {
            $movimientos = MovementProduct::where('movement_id', $request->id)->orderBy('created_at', 'asc')->get();
            return new JsonResponse([
                'data' => $movimientos,
                'type' => 'success',
                'html' => view('admin.movimientos.ingresos.detalleConfirm', compact('movimientos'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
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
