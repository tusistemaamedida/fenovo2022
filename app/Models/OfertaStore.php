<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfertaStore extends Model
{
    protected $table   = 'oferta_store';
    public $timestamps = false;

    protected $casts = [
        'oferta_id' => 'int',
        'store_id'  => 'int',
    ];

    protected $fillable = [
        'oferta_id',
        'store_id',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function oferta()
    {
        return $this->belongsTo(ProductOferta::class);
    }
}
