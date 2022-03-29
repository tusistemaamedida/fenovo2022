<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SenasaDefinition;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;

class SenasaDefinitionController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $senasa = SenasaDefinition::all();
            return Datatables::of($senasa)
                ->addIndexColumn()
                ->addColumn('inactivo', function ($senasa) {
                    return ($senasa->active == 0) ? '<i class="fa fa-check-circle text-danger"></i>' : null;
                })
                ->addColumn('edit', function ($senasa) {
                    $ruta = route('senasaes.edit', ['id' => $senasa->id]);
                    return '<a class="dropdown-item" href="' . $ruta . '"> <i class="fa fa-edit"></i> </a>';
                })
                ->addColumn('destroy', function ($senasa) {
                    $ruta = 'destroy(' . $senasa->id . ",'" . route('senasaes.destroy') . "')";
                    return '<a class="dropdown-item" href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-trash"></i> </a>';
                })
                ->rawColumns(['inactivo', 'edit', 'destroy'])
                ->make(true);
        }
        return view('admin.senasaes.index');
    }

    public function add()
    {
        try {
            $senasae = null;
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.senasaes.insertByAjax', compact('senasae'))->render(),
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
            $this->senasaeRepository->create($data);
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
        
    }

    public function update(Request $request)
    {
        $data['name']   = $request->name;
        $data['active'] = ($request->has('active')) ? 1 : 0;
        $this->senasaeRepository->update($request->input('senasae_id'), $data);
        $this->senasaeRepository->getOne($request->senasae_id)->syncPermissions($request->input('permissions'));
        return redirect()->route('senasaes.index');
    }

    public function destroy(Request $request)
    {
        $this->senasaeRepository->update($request->id, ['active' => 0]);
        return new JsonResponse(['msj' => 'Eliminado ... ', 'type' => 'success']);
    }
}
