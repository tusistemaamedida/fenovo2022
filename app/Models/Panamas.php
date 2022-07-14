<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panamas extends Model
{
    protected $table = 'panamas';
	protected $fillable = [
		'movement_id',
		'client_name',
		'client_address',
		'client_cuit',
		'client_iva_type',
		'pto_vta',
		'cip',
		'neto105',
		'iva_neto105',
		'neto21',
		'iva_neto21',
		'totalIibb',
		'totalConIva',
        'costo_fenovo_total',
        'orden',
        'tipo',
        'created_at',
        'emision_store'
	];
}
