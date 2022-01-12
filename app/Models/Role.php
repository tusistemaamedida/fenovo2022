<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * 
 * @property int $id
 * @property string $name
 * @property bool $active
 * 
 * @property Collection|Permission[] $permissions
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Role extends Model
{
	protected $table = 'roles';
	public $timestamps = false;

	protected $casts = [
		'active' => 'bool'
	];

	protected $fillable = [
		'name',
		'active'
	];

	public function permissions()
	{
		return $this->hasMany(Permission::class, 'rol_id');
	}

	public function users()
	{
		return $this->hasMany(User::class, 'rol_id');
	}
}
