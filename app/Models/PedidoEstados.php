<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PedidoEstados extends Model
{
    protected $table = 'pedidos_estados';
    public $timestamps = false;

    protected $dates = [
        'fecha',
    ];

    protected $fillable = [
        'user_id',
        'pedido_id',
        'estado',
        'fecha'
    ];
}
