<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovementProductTemp extends Model
{
    protected $table = 'movement_productstemp';

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
        'exported_number',
        'unit_package',
        'unit_type',
        'invoice',
        'cyo',
        'iibb',
        'bultos',
        'entry',
        'egress',
        'balance',
        'unit_price',
        'cost_fenovo',
        'tasiva',
    ];

    public function movement()
    {
        return $this->belongsTo(MovementTemp::class);
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
