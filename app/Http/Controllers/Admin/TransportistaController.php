<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transportista;
use App\Repositories\TransportistaRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;

class TransportistaController extends Controller
{
    public function __construct(TransportistaRepository $transportistaRepository)
    {
        $this->transportistaRepository = $transportistaRepository;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $transportista = $this->transportistaRepository->getAll();

            return Datatables::of($transportista)
                ->addIndexColumn()
                ->addColumn('transportista', function ($transportista) {
                    return $transportista->nombre;
                })
                ->addColumn('edit', function ($transportista) {
                    $ruta = 'edit(' . $transportista->id . ",'" . route('transportistas.edit') . "')";
                    return '<a href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-edit"></i> </a>';
                })
                ->addColumn('destroy', function ($transportista) {
                    $transportista = 'destroy(' . $transportista->id . ",'" . route('transportistas.destroy') . "')";
                    return '<a href="javascript:void(0)" onclick="' . $transportista . '"> <i class="fa fa-trash"></i> </a>';
                })
                ->rawColumns(['transportista', 'edit', 'destroy'])
                ->make(true);
        }
        return view('admin.transportistas.index');
    }

    public function add()
    {
        try {
            $transportista = null;
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.transportistas.insertByAjax', compact('transportista'))->render(),
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
            $this->transportistaRepository->create($data);
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
            $transportista = $this->transportistaRepository->getOne($request->id);
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.transportistas.insertByAjax', compact('transportista'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function update(Request $request)
    {
        try {
            $transportista = $this->transportistaRepository->getOne($request->transportista_id);
            $transportista->fill($request->all());
            $transportista->active = isset($request->active) ? 1 : 0;
            $transportista->save();
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.transportistas.insertByAjax', compact('transportista'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function destroy(Request $request)
    {
        $transportista         = Transportista::find($request->id);
        $transportista->active = 0;
        $transportista->save();
        return new JsonResponse(['msj' => 'Eliminado ... ', 'type' => 'success']);
    }
}
