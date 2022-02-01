<?php

namespace App\Http\Controllers\Admin\Movimientos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Models\Movement;
use App\Models\MovementProduct;
use App\Models\Proveedor;
use App\Repositories\ProveedorRepository;
use App\Repositories\ProductRepository;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class IngresosController extends Controller
{
    private $proveedorRepository;

    public function __construct(ProveedorRepository $proveedorRepository, ProductRepository $productRepository)
    {
        $this->proveedorRepository = $proveedorRepository;
        $this->productRepository = $productRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $movement = Movement::all()->sortByDesc('created_at');
            return Datatables::of($movement)
                ->addIndexColumn()
                ->editColumn('date', function ($movement) {
                    return date("Y-m-d", strtotime($movement->date));
                })
                ->editColumn('type', function ($movement) {
                    return ($movement->type);
                })
                ->editColumn('updated_at', function ($movement) {
                    return date('Y-m-d H:i:s', strtotime($movement->updated_at));
                })
                ->addColumn('edit', function ($movement) {
                    return '<a class="dropdown-item" href="' . route('ingresos.edit', ['id' => $movement->id]) . '"> <i class="fa fa-edit"></i> </a>';
                })
                ->rawColumns(['date', 'type', 'edit'])
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
        $movement = Movement::find($request->id);
        $productos = $this->productRepository->getByProveedorIdPluck($movement->from);
        $proveedor = Proveedor::find($movement->from);
        $movimientos = MovementProduct::where('movement_id', $request->id)->orderBy('created_at', 'desc')->get();
        return view('admin.movimientos.ingresos.edit', compact('movement', 'proveedor', 'productos', 'movimientos'));
    }

    public function destroy(Request $request)
    {
        //DB::table('movements')->where('id', $request->id)->update(['status' => 'CANCELED']);
        Movement::where('id', $request->id)->update(['status' => 'CANCELED']);
        return redirect()->route('ingresos.index');
    }

    public function getMovements(Request $request)
    {
        try {
            $movimientos = MovementProduct::where('movement_id', $request->id)->orderBy('created_at', 'desc')->get();
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
        $term = $request->term ?: '';
        $valid_names = [];

        $proveedors =  $this->proveedorRepository->search($term);
        foreach ($proveedors as $proveedor) {
            $valid_names[] = ['id' => $proveedor->id, 'text' => $proveedor->displayName()];
        }

        return new JsonResponse($valid_names);
    }
}
