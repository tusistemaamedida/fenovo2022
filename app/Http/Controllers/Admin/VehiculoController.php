<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehiculo;
use App\Repositories\TransportistaRepository;
use App\Repositories\VehiculoRepository;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;

class VehiculoController extends Controller
{
    public function __construct(VehiculoRepository $vehiculoRepository, TransportistaRepository $transportistaRepository)
    {
        $this->vehiculoRepository      = $vehiculoRepository;
        $this->transportistaRepository = $transportistaRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->ajax()) {
                $vehiculo = Vehiculo::all();

                return Datatables::of($vehiculo)
                    ->addIndexColumn()

                    ->addColumn('transportista', function ($vehiculo) {
                        return ($vehiculo->transportista) ? $vehiculo->transportista->nombre : null;
                    })
                    ->addColumn('edit', function ($vehiculo) {
                        $ruta = 'edit(' . $vehiculo->id . ",'" . route('vehiculos.edit') . "')";
                        return '<a class="dropdown-item" href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-edit"></i> </a>';
                    })
                    ->addColumn('destroy', function ($vehiculo) {
                        $vehiculo = 'destroy(' . $vehiculo->id . ",'" . route('vehiculos.destroy') . "')";
                        return '<a class="dropdown-item" href="javascript:void(0)" onclick="' . $vehiculo . '"> <i class="fa fa-trash"></i> </a>';
                    })
                    ->rawColumns(['transportista', 'edit', 'destroy'])
                    ->make(true);
            }
        }
        return view('admin.vehiculos.index');
    }

    public function add()
    {
        try {
            $vehiculo       = null;
            $transportistas = $this->transportistaRepository->getAll();
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.vehiculos.insertByAjax', compact('vehiculo', 'transportistas'))->render(),
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
            $this->vehiculoRepository->create($data);
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
            $vehiculo       = $this->vehiculoRepository->getOne($request->id);
            $transportistas = $this->transportistaRepository->getAll();
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.vehiculos.insertByAjax', compact('vehiculo', 'transportistas'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function update(Request $request)
    {
        try {
            $vehiculo = $this->vehiculoRepository->getOne($request->vehiculo_id);
            $vehiculo->fill($request->all());
            $vehiculo->active = isset($request->active) ? 1 : 0;
            $vehiculo->save();
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
        $vehiculo         = Vehiculo::find($request->id);
        $vehiculo->active = 0;
        $vehiculo->save();
        return new JsonResponse(['msj' => 'Eliminado ... ', 'type' => 'success']);
    }
}
