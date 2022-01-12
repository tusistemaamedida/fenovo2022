<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdonisSchema
 * 
 * @property int $id
 * @property string $name
 * @property int $batch
 * @property Carbon|null $migration_time
 *
 * @package App\Models
 */
class AdonisSchema extends Model
{
	protected $table = 'adonis_schema';
	public $timestamps = false;

	protected $casts = [
		'batch' => 'int'
	];

	protected $dates = [
		'migration_time'
	];

	protected $fillable = [
		'name',
		'batch',
		'migration_time'
	];
}
