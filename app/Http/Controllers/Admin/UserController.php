<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\JsonResponse;
use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use App\Http\Requests\Users\AddRequest;

class UserController extends Controller
{
    private $userRepository;
    private $roleRepository;

    public function __construct(UserRepository $userRepository,RoleRepository $roleRepository){
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function list(){
        $users = $this->userRepository->paginate(20);
        return view('admin.users.list', compact('users'));
    }

    public function edit(Request $request){
        try {
            $roles = $this->roleRepository->getActives();
            $user = $this->userRepository->getOne($request->id);
            return new JsonResponse([
                'msj'=>'Producto guardado correctamente!',
                'type'=>'success',
                'html' => view('admin.users.insertByAjax',compact('user','roles'))->render()
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj'=> $e->getMessage(),'type'=>'error']);
        }
    }

    public function update(AddRequest $request){
        try {
            $data = $request->except(['_token','user_id','active']);
            $data['active'] = ($request->has('active'))?1:0;
            $users = $this->userRepository->update($request->input('user_id'),$data);
            return new JsonResponse([
                'msj'=>'Usuario actualizado correctamente!',
                'type'=>'success'
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj'=> $e->getMessage(),'type'=>'error']);
        }
    }
}
