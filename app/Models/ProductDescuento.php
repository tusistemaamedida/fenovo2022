<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDescuento extends Model
{
    protected $table   = 'product_descuentos';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'codigo',
        'descripcion',
        'descuento',
        'cantidad',
        'active',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'cod_descuento');
    }
}
