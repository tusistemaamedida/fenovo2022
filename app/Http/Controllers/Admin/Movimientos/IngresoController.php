<?php

namespace App\Http\Controllers\Admin\Movimientos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Models\Movement;
use App\Models\Proveedor;
use App\Repositories\ProveedorRepository;

use Yajra\DataTables\Facades\DataTables;

class IngresoController extends Controller
{
    private $proveedorRepository;

    public function __construct(ProveedorRepository $proveedorRepository)
    {
        $this->proveedorRepository = $proveedorRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $movement = Movement::all();
            return Datatables::of($movement)
                ->addIndexColumn()
                ->editColumn('date', function ($movement) {
                    return date("Y-m-d", strtotime($movement->date));
                })
                ->editColumn('type', function ($movement) {
                    return ($movement->type);
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
        $movement = null;
        $proveedores = Proveedor::orderBy('name')->get();
        return view('admin.movimientos.ingresos.form', compact('movement', 'proveedores'));
    }

    public function store(Request $request)
    {
        try {
            $data = $request->except(['_token']);
            $data['active'] = 1;
            $this->storeRepository->create($data);
            return new JsonResponse([
                'msj' => 'Actualización correcta !',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }
}
