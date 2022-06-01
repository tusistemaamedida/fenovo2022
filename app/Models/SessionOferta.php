<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionOferta extends Model
{
    protected $table   = 'session_ofertas';
    public $timestamps = true;

    protected $casts = [
        'product_id'        => 'int',
        'plistproveedor'    => 'float',
        'descproveedor'     => 'float',
        'costfenovo'        => 'float',
        'costdolar'         => 'float',
        'mupfenovo'         => 'float',
        'tasiva'            => 'float',
        'plist0'            => 'float',
        'plist0neto'        => 'float',
        'plist0iva'         => 'float',
        'contribution_fund' => 'float',
        'plist1'            => 'float',
        'muplist1'          => 'float',
        'plist2'            => 'float',
        'muplist2'          => 'float',
        'p1tienda'          => 'float',
        'mup1'              => 'float',
        'descp1'            => 'float',
        'p1may'             => 'float',
        'mupp1may'          => 'float',
        'cantmay1'          => 'int',
        'p2tienda'          => 'float',
        'mup2'              => 'float',
        'descp2'            => 'float',
        'p2may'             => 'float',
        'mupp2may'          => 'float',
        'cantmay2'          => 'int',
        'comlista1'         => 'float',
        'comlista2'         => 'float',
    ];

    protected $fillable = [
        'product_id',
        'plistproveedor',
        'descproveedor',
        'costfenovo',
        'costdolar',
        'mupfenovo',
        'tasiva',
        'plist0',
        'plist0neto',
        'plist0iva',
        'contribution_fund',
        'plist1',
        'muplist1',
        'plist2',
        'muplist2',
        'p1tienda',
        'mup1',
        'descp1',
        'p1may',
        'mupp1may',
        'cantmay1',
        'p2tienda',
        'mup2',
        'descp2',
        'p2may',
        'mupp2may',
        'cantmay2',
        'comlista1',
        'comlista2',
        'fecha_desde',
        'fecha_hasta',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function stores()
    {
        return $this->belongsToMany(Store::class, OfertaStore::class, 'session_id', 'store_id');
    }

    public function hasExcepcion()
    {	
        return $this->belongsToMany(Store::class, OfertaStore::class, 'session_id', 'store_id')->exists();
    }
}
