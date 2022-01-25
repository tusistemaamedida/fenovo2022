<?php

namespace App\Http\Controllers\Admin\Movimientos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Models\Movement;

use Yajra\DataTables\Facades\DataTables;

class IngresoController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $movement = Movement::all();
            return Datatables::of($movement)
                ->addIndexColumn()
                ->addColumn('inactivo', function ($movement) {
                    return ($movement->active == 0) ? '<i class="fa fa-check-circle text-danger"></i>' : null;
                })
                ->addColumn('edit', function ($movement) {
                    return '<a class="dropdown-item" href="' . route('stores.edit', ['id' => $movement->id]) . '"> <i class="fa fa-edit"></i> </a>';
                })
                ->addColumn('destroy', function ($movement) {
                    $ruta = "destroy(" . $movement->id . ",'" . route('stores.destroy') . "')";
                    return '<a class="dropdown-item" href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-trash"></i> </a>';
                })
                ->rawColumns(['inactivo', 'edit', 'destroy'])
                ->make(true);
        }
        return view('admin.movimientos.ingresos.index');
    }
}
