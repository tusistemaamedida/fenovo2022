<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Regione
 * 
 * @property int $id
 * @property string|null $name
 * @property bool $active
 * 
 * @property Collection|Store[] $stores
 *
 * @package App\Models
 */
class Regione extends Model
{
	protected $table = 'regiones';
	public $timestamps = false;

	protected $casts = [
		'active' => 'bool'
	];

	protected $fillable = [
		'name',
		'active'
	];

	public function stores()
	{
		return $this->hasMany(Store::class, 'region_id');
	}
}
