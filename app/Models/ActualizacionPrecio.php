<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActualizacionPrecio extends Model
{
    use HasFactory;

    protected $table   = 'actualizacion_precios';
    public $timestamps = true;

    protected $fillable = [
        'id',
        'fecha',
        'registros',
        'active',
    ];
}
