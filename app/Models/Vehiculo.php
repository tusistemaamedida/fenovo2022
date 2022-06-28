<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    protected $table = 'vehiculos';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'tipo',
        'marca',
        'capacidad',
        'patente',
        'chofer',
        'transportista_id',
        'store_id',
        'senasa',
        'active',
    ];

    public function transportista()
    {
        return $this->belongsTo(Transportista::class, 'transportista_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
