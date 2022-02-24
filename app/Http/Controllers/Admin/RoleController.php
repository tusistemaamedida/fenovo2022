<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\EditRequest;
use App\Repositories\RoleRepository;

use Illuminate\Http\JsonResponse;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
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
                ->addColumn('inactivo', function ($rol) {
                    return ($rol->active == 0) ? '<i class="fa fa-check-circle text-danger"></i>' : null;
                })
                ->addColumn('edit', function ($rol) {
                    $ruta = route('roles.edit', ['id' => $rol->id]);
                    return '<a class="dropdown-item" href="' . $ruta . '"> <i class="fa fa-edit"></i> </a>';
                })
                ->addColumn('destroy', function ($rol) {
                    $ruta = 'destroy(' . $rol->id . ",'" . route('roles.destroy') . "')";
                    return '<a class="dropdown-item" href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-trash"></i> </a>';
                })
                ->rawColumns(['inactivo', 'edit', 'destroy'])
                ->make(true);
        }
        return view('admin.roles.index');
    }

    public function add()
    {
        try {
            $role = null;
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.roles.insertByAjax', compact('role'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function store(EditRequest $request)
    {
        try {
            $data           = $request->except(['_token']);
            $data['active'] = 1;
            $this->roleRepository->create($data);
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
        $role        = $this->roleRepository->getOne($request->id);
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(EditRequest $request)
    {
        $data['name']   = $request->name;
        $data['active'] = ($request->has('active')) ? 1 : 0;
        $this->roleRepository->update($request->input('role_id'), $data);
        $this->roleRepository->getOne($request->role_id)->syncPermissions($request->input('permissions'));
        return redirect()->route('roles.index');
    }

    public function destroy(Request $request)
    {
        $this->roleRepository->update($request->id, ['active' => 0]);
        return new JsonResponse(['msj' => 'Eliminado ... ', 'type' => 'success']);
    }
}
