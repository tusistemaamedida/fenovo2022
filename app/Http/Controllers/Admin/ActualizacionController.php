<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActualizacionPrecio;
use App\Repositories\ActualizacionRepository;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;

class ActualizacionController extends Controller
{
    private $actualizacionRepository;

    public function __construct(ActualizacionRepository $actualizacionRepository)
    {
        $this->actualizacionRepository = $actualizacionRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $actualizacion = ActualizacionPrecio::where('active', 1)->orderBy('fecha', 'desc')->get();
            return Datatables::of($actualizacion)
                ->addIndexColumn()
                ->addColumn('fecha', function ($actualizacion) {
                    return date('d-m-Y', strtotime($actualizacion->fecha));
                })
                ->editColumn('registros', function ($actualizacion) {
                    return ($actualizacion->registros > 0) ? $actualizacion->registros : '<span class=" text-danger" >pendiente</span>';
                })
                ->addColumn('edit', function ($actualizacion) {
                    $ruta = 'edit(' . $actualizacion->id . ",'" . route('actualizacion.edit') . "')";
                    return '<a href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-edit"></i> </a>';
                })
                ->addColumn('destroy', function ($actualizacion) {
                    $ruta = 'destroy(' . $actualizacion->id . ",'" . route('actualizacion.destroy') . "')";
                    return '<a class="dropdown-item" href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-trash"></i> </a>';
                })
                ->rawColumns(['fecha', 'registros', 'edit', 'destroy'])
                ->make(true);
        }
        return view('admin.actualizaciones.index');
    }

    public function add()
    {
        try {
            $actualizacion = null;
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.actualizaciones.insertByAjax', compact('actualizacion'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function store(Request $request)
    {
        try {
            $data           = $request->except(['_token']);
            $data['active'] = 1;
            ActualizacionPrecio::create($data);
            return new JsonResponse([
                'msj'  => 'Actualización correcta !',
                'type' => 'success',
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function edit(Request $request)
    {
        try {
            $actualizacion = ActualizacionPrecio::find($request->id);
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.actualizaciones.insertByAjax', compact('actualizacion'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function update(Request $request)
    {
        try {
            $data['fecha']  = $request->fecha;
            $data['active'] = ($request->has('active')) ? 1 : 0;
            $this->actualizacionRepository->update($request->input('actualizacion_id'), $data);
            return new JsonResponse([
                'msj'  => 'Actualización correcta !',
                'type' => 'success',
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function destroy(Request $request)
    {
        ActualizacionPrecio::find($request->id)->update(['active' => 0]);
        return new JsonResponse(['msj' => 'Eliminado ... ', 'type' => 'success']);
    }
}
