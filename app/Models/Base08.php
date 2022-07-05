<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Base08 extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'base008';

    protected $fillable = [
        'cod_fenovo',
        'stock',
    ];
}
