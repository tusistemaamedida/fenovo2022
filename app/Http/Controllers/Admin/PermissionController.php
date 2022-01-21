<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;

use App\Http\Requests\Permissions\EditRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    private $permissionRepository;
    private $roleRepository;

    public function __construct(PermissionRepository $permissionRepository, RoleRepository $roleRepository)
    {
        $this->permissionRepository = $permissionRepository;
        $this->roleRepository = $roleRepository;
    }

    public function list()
    {
        $permissions = $this->permissionRepository->paginate(20);
        return view('admin.permissions.list', compact('permissions'));
    }

    public function add()
    {
        try {
            $permission = null;
            $roles      = $this->roleRepository->getActives();
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.permissions.insertByAjax', compact('permission', 'roles'))->render()
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function store(EditRequest $request)
    {
        try {

            $data = $request->except(['_token', 'active']);
            $data['active'] = 1;
            $permission = $this->permissionRepository->create($data);

            $role = $this->roleRepository->getOne($request->rol_id);
            $role->syncPermissions($permission);

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
            $permission = $this->permissionRepository->getOne($request->id);
            $roles      = $this->roleRepository->getActives();
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.permissions.insertByAjax', compact('permission', 'roles'))->render()
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function update(EditRequest $request)
    {
        try {
            $data['name']   = $request->name;
            $data['guard_name'] = $request->guard_name;
            $data['active'] = ($request->has('active')) ? 1 : 0;
            $permission = $this->permissionRepository->update($request->input('permission_id'), $data);

            $role = $this->roleRepository->getOne($request->rol_id);
            $role->syncPermissions($permission);

            return new JsonResponse([
                'msj' => 'Actualización correcta !',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function destroy(Permission $permission)
    {
        $data['active'] = 0;
        $this->permissionRepository->update($permission->id, $data);
        return redirect()->route('permissions.list');
    }
}
