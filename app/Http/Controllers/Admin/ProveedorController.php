<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\ProveedorRepository;

class ProveedorController extends Controller
{
    private $proveedorRepository;

    public function __construct(ProveedorRepository $proveedorRepository){
        $this->proveedorRepository = $proveedorRepository;
    }

    public function list(){
    
        $proveedors = $this->proveedorRepository->paginate(1000);
        return view('admin.proveedors.list', compact('proveedors'));
    }

    public function edit(Request $request){
        $proveedor = $this->proveedorRepository->getOne($request->id);
        return $proveedor;
    }
}
