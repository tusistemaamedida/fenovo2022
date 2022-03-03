<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    use HasFactory;

    protected $table = 'rutas';

    protected $fillable = [
        'id',
        'nombre',
        'active',
    ];

    public function vehiculos()
    {
        return $this->belongsToMany(Vehiculo::class, RutaVehiculo::class);
    }

    public function localidades()
    {
        return $this->belongsToMany(Localidad::class, RutaLocalidad::class);
    }

    public function nombres_localidades()
    {
        $localidades    = $this->localidades;
        $arrLocalidades = [];
        foreach ($localidades as $localidad) {
            array_push($arrLocalidades, $localidad['nombre']);
        }
        return $arrLocalidades;
    }

    public function tipos_vehiculos()
    {
        $vehiculos    = $this->vehiculos;
        $arrVehiculos = [];
        foreach ($vehiculos as $vehiculo) {
            array_push($arrVehiculos, $vehiculo['tipo'] . ',' . $vehiculo['capacidad']);
        }
        return $arrVehiculos;
    }
}
