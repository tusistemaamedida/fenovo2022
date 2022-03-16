<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfertaStore extends Model
{
    protected $table   = 'oferta_store';
    public $timestamps = false;

    protected $casts = [
        'session_id' => 'int',
        'store_id'   => 'int',
    ];

    protected $fillable = [
        'session_id',
        'store_id',
    ];

    public function session()
    {
        return $this->belongsTo(SessionOferta::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
