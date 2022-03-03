<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transportista extends Model
{
    use HasFactory;

    protected $table = 'transportistas';

    protected $fillable = [
        'id',
        'nombre',
        'cuit',
        'contacto',
        'direccion',
        'telefono',
        'email',
        'active',
    ];

    public function vehiculos()
    {
        return $this->belongsToMany(Vehiculo::class, TransportistaVehiculo::class);
    }
}
