<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Models\Proveedor;
use App\Repositories\ProveedorRepository;
use App\Repositories\EnumRepository;

use App\Http\Requests\Proveedors\EditRequest;

class ProveedorController extends Controller
{
    private $proveedorRepository;

    public function __construct(ProveedorRepository $proveedorRepository, EnumRepository $enumRepository)
    {
        $this->proveedorRepository = $proveedorRepository;
        $this->enumRepository = $enumRepository;
    }

    public function list()
    {
        $proveedors = $this->proveedorRepository->paginate(20);
        return view('admin.proveedors.list', compact('proveedors'));
    }

    public function add()
    {
        $proveedor  = null;
        $states     = $this->enumRepository->getType('state');
        $ivaType    = $this->enumRepository->getType('iva');
        return  view('admin.proveedors.form', compact('proveedor', 'ivaType', 'states'));
    }

    public function store(EditRequest $request)
    {
        try {
            $data = $request->except(['_token']);
            $data['active'] = 1;
            $this->proveedorRepository->create($data);
            return new JsonResponse([
                'msj' => 'Actualización correcta !',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }


    public function edit(Request $request)
    {
        $proveedor = $this->proveedorRepository->getOne($request->id);
        $states     = $this->enumRepository->getType('state');
        $ivaType    = $this->enumRepository->getType('iva');
        return  view('admin.proveedors.form', compact('proveedor', 'ivaType', 'states'));
    }

    public function update(Request $request)
    {
        try {
            $data = $request->except(['_token', 'proveedor_id', 'active']);
            $data['active'] = ($request->has('active')) ? 1 : 0;
            $this->proveedorRepository->update($request->input('proveedor_id'), $data);
            return new JsonResponse([
                'msj' => 'Actualización correcta !',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function destroy(Proveedor $proveedor)
    {
        $data['active'] = 0;
        $this->proveedorRepository->update($proveedor->id, $data);
        return redirect()->route('proveedors.list');
    }
}
