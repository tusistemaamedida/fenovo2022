<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Palet extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'palets';

    protected $fillable = [
        'id',
        'nombre',
    ];

}
