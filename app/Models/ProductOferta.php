<?php

/**
 * Created by Reliese Model.
 */

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
}
