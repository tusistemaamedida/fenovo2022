<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FleteSetting extends Model
{
    use HasFactory;

    protected $table = 'flete_setting';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'hasta',
        'porcentaje',
        'active',
    ];
}
