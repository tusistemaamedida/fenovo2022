<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Permission
 * 
 * @property int $id
 * @property string $name
 * @property int|null $rol_id
 * @property string|null $description
 * @property string $key
 * @property bool $active
 * 
 * @property Role|null $role
 *
 * @package App\Models
 */
class Permission extends Model
{
	protected $table = 'permissions';
	public $timestamps = false;

	protected $casts = [
		'rol_id' => 'int',
		'active' => 'bool'
	];

	protected $fillable = [
		'name',
		'rol_id',
		'description',
		'key',
		'active'
	];

	public function role()
	{
		return $this->belongsTo(Role::class, 'rol_id');
	}
}
