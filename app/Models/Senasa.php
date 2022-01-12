<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Senasa
 * 
 * @property int $id
 * @property string|null $movimientos
 * @property string|null $habilitacion_nro
 * @property string|null $patente_nro
 * @property string|null $precintos
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Senasa extends Model
{
	protected $table = 'senasa';

	protected $fillable = [
		'movimientos',
		'habilitacion_nro',
		'patente_nro',
		'precintos'
	];
}
