<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoProductos extends Model
{
    protected $table = 'pedido_productos';

    protected $casts = [
        'pedido_id'  => 'int',
        'entidad_id'   => 'int',
        'entidad_tipo' => 'string',
        'product_id'   => 'int',
        'unit_package' => 'float',
        'unit_type'    => 'string',
        'invoice'      => 'bool',
        'bultos'       => 'int'
    ];

    protected $fillable = [
        'pedido_id',
        'entidad_id',
        'entidad_tipo',
        'product_id',
        'tasiva',
        'cost_fenovo',
        'unit_price',
        'unit_package',
        'unit_type',
        'invoice',
        'iibb',
        'bultos',
        'bultos_enviados',
        'bultos_pendientes',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
