<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovementProduct extends Model
{
    protected $table = 'movement_products';

    protected $casts = [
        'movement_id'  => 'int',
        'store_id'     => 'int',
        'product_id'   => 'int',
        'unit_package' => 'int',
        'invoice'      => 'bool',
        'bultos'       => 'int',
        'entry'        => 'float',
        'egress'       => 'float',
        'balance'      => 'float',
    ];

    protected $fillable = [
        'movement_id',
        'store_id',
        'product_id',
        'unit_package',
        'invoice',
        'bultos',
        'entry',
        'egress',
        'balance',
        'unit_price',
        'tasiva'
    ];

    public function movement()
    {
        return $this->belongsTo(Movement::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
