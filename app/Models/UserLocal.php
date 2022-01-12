<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserLocal
 * 
 * @property int $id
 * @property int|null $user_id
 * @property int|null $store_id
 * 
 * @property Store|null $store
 * @property User|null $user
 *
 * @package App\Models
 */
class UserLocal extends Model
{
	protected $table = 'user_locals';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'store_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'store_id'
	];

	public function store()
	{
		return $this->belongsTo(Store::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
