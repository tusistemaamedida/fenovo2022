<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Iibb
 * 
 * @property int $id
 * @property string|null $state
 * @property float|null $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Iibb extends Model
{
	protected $table = 'iibbs';

	protected $casts = [
		'value' => 'float'
	];

	protected $fillable = [
		'state',
		'value'
	];
}
