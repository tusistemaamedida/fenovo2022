<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\PermissionRepository;

class PermissionController extends Controller
{
    private $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository){
        $this->permissionRepository = $permissionRepository;
    }

    public function list(){
        $permissions = $this->permissionRepository->paginate(20);
        return view('admin.permissions.list', compact('permissions'));
    }

    public function edit(Request $request){
        $permission = $this->permissionRepository->getOne($request->id);
        return $permission;
    }

}
