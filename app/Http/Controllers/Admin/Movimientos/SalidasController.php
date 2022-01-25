<?php

namespace App\Http\Controllers\Admin\Movimientos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalidasController extends Controller
{
    public function add(){
        return view('admin.products.add', compact('alicuotas', 'categories', 'types', 'proveedores', 'senasaDefinitions'));
    }
}
