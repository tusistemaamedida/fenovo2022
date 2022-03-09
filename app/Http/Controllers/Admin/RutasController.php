<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ruta;
use App\Repositories\LocalidadRepository;
use App\Repositories\RutaRepository;
use App\Repositories\TransportistaRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;

class RutasController extends Controller
{
    public function __construct(
        RutaRepository $rutaRepository,
        LocalidadRepository $localidadRepository,
        TransportistaRepository $transportistaRepository
    ) {
        $this->rutaRepository          = $rutaRepository;
        $this->localidadRepository     = $localidadRepository;
        $this->transportistaRepository = $transportistaRepository;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $ruta = $this->rutaRepository->getAll();

            return Datatables::of($ruta)
                ->addIndexColumn()
                ->addColumn('ruta', function ($ruta) {
                    return $ruta->nombre;
                })
                ->addColumn('localidad', function ($ruta) {
                    return $ruta->nombres_localidades();
                })
                ->addColumn('transportistas', function ($ruta) {
                    return $ruta->nombres_transportistas();
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

    public function add()
    {
        try {
            $ruta           = null;
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.rutas.insertByAjax', compact('ruta'))->render(),
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
            $this->rutaRepository->create($data);
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
        $ruta           = $this->rutaRepository->getOne($request->id);
        $localidades    = $this->localidadRepository->getAll();
        $transportistas = $this->transportistaRepository->getAll();
        return view('admin.rutas.edit', compact('ruta', 'localidades', 'transportistas'));
    }

    public function update(Request $request)
    {
        $data['nombre'] = strtoupper(trim($request->nombre));
        $data['active'] = ($request->has('active')) ? 1 : 0;
        $this->rutaRepository->update($request->input('ruta_id'), $data);
        $ruta = $this->rutaRepository->getOne($request->ruta_id);
        $ruta->localidades()->sync($request->get('localidades'));
        $ruta->transportistas()->sync($request->get('transportistas'));
        return redirect()->route('rutas.index');
    }

    public function destroy(Request $request)
    {
        Ruta::find($request->id)->delete();
        return new JsonResponse(['msj' => 'Eliminado ... ', 'type' => 'success']);
    }
}
