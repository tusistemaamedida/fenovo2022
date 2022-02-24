<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permissions\EditRequest;
use App\Repositories\PermissionRepository;

use App\Repositories\RoleRepository;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    private $permissionRepository;
    private $roleRepository;

    public function __construct(PermissionRepository $permissionRepository, RoleRepository $roleRepository)
    {
        $this->permissionRepository = $permissionRepository;
        $this->roleRepository       = $roleRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $permission = Permission::all()->where('active', 1)->sortBy('name');
            return Datatables::of($permission)
                ->addIndexColumn()
                ->addColumn('rol', function ($permission) {
                    return isset($permission->roles->pluck('id')[0]) ? $permission->roles->pluck('name')[0] : null;
                })
                ->addColumn('inactivo', function ($permission) {
                    return ($permission->active == 0) ? '<i class="fa fa-check-circle text-danger"></i>' : null;
                })
                ->addColumn('edit', function ($permission) {
                    $ruta = 'edit(' . $permission->id . ",'" . route('permissions.edit') . "')";
                    return '<a class="btn-link" href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-edit"></i> </a>';
                })
                ->addColumn('destroy', function ($permission) {
                    $ruta = 'destroy(' . $permission->id . ",'" . route('permissions.destroy') . "')";
                    return '<a class="btn-link" href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-trash"></i> </a>';
                })
                ->rawColumns(['rol', 'inactivo', 'edit', 'destroy'])
                ->make(true);
        }
        return view('admin.permissions.index');
    }

    public function add()
    {
        try {
            $permission = null;
            $roles      = $this->roleRepository->getActives();
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.permissions.insertByAjax', compact('permission', 'roles'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function store(EditRequest $request)
    {
        try {
            $data           = $request->except(['_token', 'active']);
            $data['active'] = 1;
            $permission     = $this->permissionRepository->create($data);
            $role           = $this->roleRepository->getOne($request->rol_id);

            $permission->assignRole($role);

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
            $permission = $this->permissionRepository->getOne($request->id);
            $roles      = $this->roleRepository->getActives();
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.permissions.insertByAjax', compact('permission', 'roles'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function update(EditRequest $request)
    {
        try {
            $data['name']       = $request->name;
            $data['guard_name'] = $request->guard_name;
            $data['active']     = ($request->has('active')) ? 1 : 0;
            $this->permissionRepository->update($request->permission_id, $data);

            $permission = $this->permissionRepository->getOne($request->permission_id);

            $role = $this->roleRepository->getOne($request->rol_id);
            $permission->syncRoles($role);

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
        $this->permissionRepository->update($request->id, ['active' => 0]);
        return new JsonResponse(['msj' => 'Eliminado ... ', 'type' => 'success']);
    }
}
