<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Repositories\RoleRepository;

use App\Http\Requests\Roles\AddRequest;

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

    public function edit(Request $request){
        try {
            $role  = $this->roleRepository->getOne($request->id);
            return new JsonResponse([
                'type'=>'success',
                'html' => view('admin.roles.insertByAjax',compact('role'))->render()
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj'=> $e->getMessage(),'type'=>'error']);
        }
    }

    public function update(AddRequest $request){
        try {
            $data = $request->except(['_token','role_id','active']);
            $data['active'] = ($request->has('active'))?1:0;
            $roles = $this->roleRepository->update($request->input('role_id'),$data);
            return new JsonResponse([
                'msj'=>'Actualización correcta !',
                'type'=>'success'
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj'=> $e->getMessage(),'type'=>'error']);
        }
    }

}
