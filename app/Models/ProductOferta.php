<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOferta extends Model
{
    protected $table   = 'product_ofertas';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'product_id',
        'fechadesde',
        'fechahasta',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function stores()
    {
        return $this->belongsToMany(Store::class, OfertaStore::class, 'oferta_id', 'store_id');
    }
}
