<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class User
 *
 * @property int         $id
 * @property string|null $name
 * @property string      $email
 * @property string|null $username
 * @property int|null    $rol_id
 * @property string|null $avatar
 * @property string|null $last_login
 * @property bool        $active
 * @property string      $password
 * @property string|null $remember_me_token
 * @property Carbon      $created_at
 * @property Carbon      $updated_at
 *
 * @property Role|null              $role
 * @property Collection|ApiToken[]  $api_tokens
 * @property Collection|UserLocal[] $user_locals
 *
 * @package App\Models
 */

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;
    protected $table = 'users';

    protected $casts = [
        'rol_id' => 'int',
        'active' => 'bool',
    ];

    protected $hidden = [
        'password',
        'remember_me_token',
    ];

    protected $fillable = [
        'id',
        'name',
        'email',
        'username',
        'avatar',
        'last_login',
        'store_active',
        'active',
        'password',
        'remember_me_token',
    ];

    public function store_active()
    {
        $store = $this->hasOne(Store::class, 'id', 'store_active')->first();
        return ($store) ? $store->description : null;
    }

    public function api_tokens()
    {
        return $this->hasMany(ApiToken::class);
    }

    public function stores()
    {
        return $this->belongsToMany(Store::class, UserStore::class);
    }

    public function rol()
    {
        return ($this->roles()->first()) ? $this->roles()->first()->name : 'Sin rol';
    }
}
