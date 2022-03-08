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
        'senasa',
        'active',
    ];

    public function transportista()
    {
        return $this->belongsTo(Transportista::class, 'transportista_id');
    }
}
