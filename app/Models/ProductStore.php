<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProductStore extends Model
{
    protected $table = 'products_store';

    protected $dates = [
        'expiration_date',
        'publication_date',
    ];

    protected $fillable = [
        'product_id',
        'store_id',
        'cod_fenovo',
        'stock_f',
        'stock_r',
        'stock_cyo'
    ];
}
