<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AlicoutaType
 * 
 * @property int $id
 * @property int|null $afip_id
 * @property float|null $value
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class AlicoutaType extends Model
{
	protected $table = 'alicouta_types';

	protected $casts = [
		'afip_id' => 'int',
		'value' => 'float'
	];

	protected $fillable = [
		'afip_id',
		'value',
		'description'
	];
}
