<?php

namespace App\Http\Controllers\Admin\Movimientos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Yajra\DataTables\Facades\DataTables;

class IngresoController extends Controller
{

    public function index(Request $request)
    {
        return 'Hola ingresos';
    }
}
