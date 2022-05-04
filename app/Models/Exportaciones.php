<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exportaciones extends Model
{
    protected $table = 'exportaciones';

    public $timestamps = true;

    protected $fillable = [
        'id',
        'archivo',
        'numero',
        'registros',
    ];
}
