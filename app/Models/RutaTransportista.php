<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RutaTransportista extends Model
{
    use HasFactory;

    protected $table   = 'ruta_transportista';

    protected $fillable = [
        'ruta_id',
        'transportista_id',
    ];

    public function rutas()
    {
        return $this->belongsTo(Ruta::class);
    }

    public function transportistas()
    {
        return $this->belongsTo(Transportista::class);
    }
}
