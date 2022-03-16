<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    use HasFactory;

    protected $table = 'localidades';

    protected $fillable = [
        'id',
        'nombre',
        'departamento',
        'provincia',
    ];

    public function rutas()
    {
        return $this->belongsToMany(Ruta::class, RutaLocalidad::class);
    }
}