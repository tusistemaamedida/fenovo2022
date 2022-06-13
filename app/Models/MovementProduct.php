<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovementProduct extends Model
{
    protected $table = 'movement_products';

    protected $casts = [
        'movement_id'  => 'int',
        'entidad_id'   => 'int',
        'entidad_tipo' => 'string',
        'product_id'   => 'int',
        'unit_package' => 'float',
        'unit_type'    => 'string',
        'invoice'      => 'bool',
        'cyo'          => 'bool',
        'bultos'       => 'int',
        'entry'        => 'float',
        'egress'       => 'float',
        'balance'      => 'float',
    ];

    protected $fillable = [
        'movement_id',
        'entidad_id',
        'entidad_tipo',
        'product_id',
        'tasiva',
        'cost_fenovo',
        'unit_price',
        'unit_package',
        'unit_type',
        'invoice',
        'cyo',
        'iibb',
        'exported_number',
        'bultos',
        'entry',
        'egress',
        'balance',
        'circuito'
    ];

    public function movement()
    {
        return $this->belongsTo(Movement::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'entidad_id');
    }
}
