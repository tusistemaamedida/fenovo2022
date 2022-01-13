<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\RoleRepository;

class RoleController extends Controller
{
    private $roleRepository;

    public function __construct(RoleRepository $roleRepository){
        $this->roleRepository = $roleRepository;
    }

    public function list(){
        $roles = $this->roleRepository->paginate(20);
        return view('admin.roles.list', compact('roles'));
    }
}
