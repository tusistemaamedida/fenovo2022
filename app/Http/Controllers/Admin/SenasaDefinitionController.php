<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SenasaDefinition;
use App\Repositories\SenasaDefinitionRepository;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;

class SenasaDefinitionController extends Controller
{
    public function __construct(
        SenasaDefinitionRepository $senasaRepository
    ) {
        $this->senasaRepository = $senasaRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $senasa = SenasaDefinition::where('active', 1)->orderBy('product_name', 'asc')->get();
            return Datatables::of($senasa)
                ->addIndexColumn()

                ->addColumn('categoria', function ($senasa) {
                    return $senasa->product_name;
                })
                ->addColumn('inactivo', function ($senasa) {
                    return ($senasa->active == 0) ? '<i class="fa fa-check-circle text-danger"></i>' : null;
                })
                ->addColumn('edit', function ($senasa) {
                    $ruta = 'edit(' . $senasa->id . ",'" . route('senasa-definition.edit') . "')";
                    return '<a class="dropdown-item" href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-edit"></i> </a>';
                })
                ->addColumn('destroy', function ($senasa) {
                    $ruta = 'destroy(' . $senasa->id . ",'" . route('senasa-definition.destroy') . "')";
                    return '<a class="dropdown-item" href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-trash"></i> </a>';
                })
                ->rawColumns(['categoria', 'inactivo', 'edit', 'destroy'])
                ->make(true);
        }
        return view('admin.senasa-definition.index');
    }

    public function add()
    {
        try {
            $senasa = null;
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.senasa-definition.insertByAjax', compact('senasa'))->render(),
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
            $this->senasaRepository->create($data);
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
            $senasa = $this->senasaRepository->getOne($request->id);
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.senasa-definition.insertByAjax', compact('senasa'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function update(Request $request)
    {
        try {
            $senasa = SenasaDefinition::find($request->id);
            $senasa->fill($request->all());
            $senasa->save();
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.senasa-definition.insertByAjax', compact('senasa'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function destroy(Request $request)
    {
        $this->senasaRepository->update($request->id, ['active' => 0]);
        return new JsonResponse(['msj' => 'Eliminado ... ', 'type' => 'success']);
    }
}
