<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Pedido extends Model
{
    protected $table = 'pedidos';
    public $timestamps = true;

    protected $dates = [
        'date',
    ];

    protected $fillable = [
        'date',
        'from',
        'status',
        'voucher_number',
        'user_id',
        'observacion',
        'movement_id'
    ];

    public function productos()
    {
        return $this->hasMany(PedidoProductos::class, 'pedido_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'from', 'id');
    }
}
