<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportistaVehiculo extends Model
{
    use HasFactory;

    protected $table   = 'transportista_vehiculo';

    protected $fillable = [
        'transportista_id',
        'vehiculo_id',
    ];

    public function transportista()
    {
        return $this->belongsTo(Transportista::class);
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }
}
