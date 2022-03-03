<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RutaLocalidad extends Model
{
    use HasFactory;

    protected $table = 'ruta_localidad';

    protected $fillable = [
        'ruta_id',
        'localidad_id',
    ];

    public function ruta()
    {
        return $this->belongsTo(Ruta::class, 'ruta_id');
    }

    public function localidad()
    {
        return $this->belongsTo(Localidad::class, 'localidad_id');
    }

    public function transportistas()
    {
        $transportistas    = RutaTransportista::where('ruta_id', $this->ruta_id)->get();
        $arrTransportistas = [];
        foreach ($transportistas as $transportista) {
            $transportista = Transportista::find($transportista->transportista_id);
            array_push($arrTransportistas, $transportista['nombre'].' ');
        }
        return $arrTransportistas;
    }
}
