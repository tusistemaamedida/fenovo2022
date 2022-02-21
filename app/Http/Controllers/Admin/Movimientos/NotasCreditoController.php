<?php

namespace App\Http\Controllers\Admin\Movimientos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotasCreditoController extends Controller
{
    public function add(){
        return view('admin.movimientos.notas-credito.add');
    }
}
