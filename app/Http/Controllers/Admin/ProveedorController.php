<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Proveedors\EditRequest;
use App\Models\Proveedor;

use App\Repositories\EnumRepository;
use App\Repositories\ProveedorRepository;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;

class ProveedorController extends Controller
{
    private $proveedorRepository;

    public function __construct(ProveedorRepository $proveedorRepository, EnumRepository $enumRepository)
    {
        $this->proveedorRepository = $proveedorRepository;
        $this->enumRepository      = $enumRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $proveedor = Proveedor::orderBy('name')->whereActive(1)->get();
            return Datatables::of($proveedor)
                ->addIndexColumn()
                ->addColumn('inactivo', function ($proveedor) {
                    return ($proveedor->active == 0) ? '<i class="fa fa-check-circle text-danger"></i>' : null;
                })
                ->addColumn('edit', function ($proveedor) {
                    return '<a href="' . route('proveedors.edit', ['id' => $proveedor->id]) . '"> <i class="fa fa-edit"></i> </a>';
                })
                ->addColumn('destroy', function ($proveedor) {
                    $ruta = 'destroy(' . $proveedor->id . ",'" . route('proveedors.destroy') . "')";
                    return '<a href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-trash"></i> </a>';
                })
                ->rawColumns(['inactivo', 'edit', 'destroy'])
                ->make(true);
        }
        return view('admin.proveedors.index');
    }

    public function add()
    {
        $proveedor = null;
        $states    = $this->enumRepository->getType('state');
        $ivaType   = $this->enumRepository->getType('iva');
        return  view('admin.proveedors.form', compact('proveedor', 'ivaType', 'states'));
    }

    public function store(EditRequest $request)
    {
        try {
            $data           = $request->except(['_token']);
            $data['active'] = 1;
            $this->proveedorRepository->create($data);
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
        $proveedor = $this->proveedorRepository->getOne($request->id);
        $states    = $this->enumRepository->getType('state');
        $ivaType   = $this->enumRepository->getType('iva');
        return  view('admin.proveedors.form', compact('proveedor', 'ivaType', 'states'));
    }

    public function update(EditRequest $request)
    {
        try {
            $data           = $request->except(['_token', 'proveedor_id', 'active']);
            $data['active'] = ($request->has('active')) ? 1 : 0;
            $this->proveedorRepository->update($request->input('proveedor_id'), $data);
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
        $this->proveedorRepository->update($request->id, ['active' => 0]);
        return new JsonResponse(['msj' => 'Eliminado ... ', 'type' => 'success']);
    }
}
