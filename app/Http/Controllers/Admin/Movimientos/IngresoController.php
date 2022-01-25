<?php

namespace App\Http\Controllers\Admin\Movimientos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Models\Store;

use Yajra\DataTables\Facades\DataTables;

class MovimientoController extends Controller
{

    public function index(Request $request)
    {
        return 'Hola ingresos';
    }
}
