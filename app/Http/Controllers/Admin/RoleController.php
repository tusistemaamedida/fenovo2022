<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Repositories\RoleRepository;

use App\Http\Requests\Roles\EditRequest;
use Spatie\Permission\Models\Role;

use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    private $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rol = Role::all();
            return Datatables::of($rol)
                ->addIndexColumn()
                ->addColumn('edit', function ($rol) {
                    $ruta = "edit(" . $rol->id . ",'" . route('roles.edit') . "')";
                    return '<a class="dropdown-item" href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-edit"></i> </a>';
                })
                ->addColumn('destroy', function ($rol) {
                    $ruta = "destroy(" . $rol->id . ",'" . route('roles.destroy') . "')";
                    return '<a class="dropdown-item" href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-trash text-danger"></i> </a>';
                })
                ->rawColumns(['edit', 'destroy'])
                ->make(true);
        }
        return view('admin.roles.index');
    }

    public function add()
    {
        try {
            $role  = null;
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.roles.insertByAjax', compact('role'))->render()
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function store(EditRequest $request)
    {
        try {
            $data = $request->except(['_token']);
            $data['active'] = 1;
            $this->roleRepository->create($data);
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
        try {
            $role  = $this->roleRepository->getOne($request->id);
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.roles.insertByAjax', compact('role'))->render()
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function update(EditRequest $request)
    {
        try {
            $data = $request->except(['_token', 'role_id', 'active']);
            $data['active'] = ($request->has('active')) ? 1 : 0;
            $this->roleRepository->update($request->input('role_id'), $data);
            return new JsonResponse([
                'msj' => 'Actualización correcta !',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function destroy(Role $role)
    {
        $data['active'] = 0;
        $this->roleRepository->update($role->id, $data);
        return redirect()->route('roles.list');
    }
}
