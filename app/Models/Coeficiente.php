<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coeficiente extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'coeficientes';

    protected $fillable = [
        'id',
        'coeficiente',
    ];
}
