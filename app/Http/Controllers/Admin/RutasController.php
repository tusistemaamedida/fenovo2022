<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RutaLocalidad;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;

class RutasController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $ruta = RutaLocalidad::all();

            return Datatables::of($ruta)
                ->addIndexColumn()
                ->addColumn('ruta', function ($ruta) {
                    return $ruta->ruta->nombre;
                })
                ->addColumn('localidad', function ($ruta) {
                    return $ruta->localidad->nombre;
                })
                ->addColumn('transportistas', function ($ruta) {
                    return $ruta->transportistas();
                })
                ->addColumn('edit', function ($ruta) {
                    return '<a class="dropdown-item" href="' . route('rutas.edit', ['id' => $ruta->id]) . '"> <i class="fa fa-edit"></i> </a>';
                })
                ->addColumn('destroy', function ($ruta) {
                    $ruta = 'destroy(' . $ruta->id . ",'" . route('rutas.destroy') . "')";
                    return '<a class="dropdown-item" href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-trash"></i> </a>';
                })
                ->rawColumns(['ruta', 'localidad', 'transportistas', 'edit', 'destroy'])
                ->make(true);
        }
        return view('admin.rutas.index');
    }
}
