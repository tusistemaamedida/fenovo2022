<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Log
 * 
 * @property int $id
 * @property string|null $log
 * @property string|null $origin
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Log extends Model
{
	protected $table = 'logs';

	protected $fillable = [
		'log',
		'origin'
	];
}
