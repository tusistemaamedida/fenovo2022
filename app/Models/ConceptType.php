<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConceptType
 * 
 * @property int $id
 * @property int|null $afip_id
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class ConceptType extends Model
{
	protected $table = 'concept_types';

	protected $casts = [
		'afip_id' => 'int'
	];

	protected $fillable = [
		'afip_id',
		'description'
	];
}
