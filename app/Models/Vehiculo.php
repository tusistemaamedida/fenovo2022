<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    protected $table = 'vehiculos';

    protected $fillable = [
        'id',
        'tipo',
        'marca',
        'capacidad',
        'patente',
        'chofer',
        'active',
    ];

    public function transportistas()
    {
        return $this->belongsToMany(Transportista::class, TransportistaVehiculo::class);
    }

    public function rutas()
    {
        return $this->belongsToMany(Ruta::class, RutaTransportista::class);
    }
}
