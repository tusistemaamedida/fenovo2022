<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    use HasFactory;

    protected $table = 'rutas';

    public $timestamps = true;

    protected $fillable = [
        'id',
        'nombre',
        'active',
    ];

    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = strtoupper(trim($value));
    }

    public function transportistas()
    {
        return $this->belongsToMany(Transportista::class, RutaTransportista::class);
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

    public function nombres_transportistas()
    {
        $transportistas    = $this->transportistas;
        $arrTransportistas = [];
        foreach ($transportistas as $transportista) {
            array_push($arrTransportistas, $transportista['nombre']);
        }
        return $arrTransportistas;
    }
}
