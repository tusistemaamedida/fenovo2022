<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Proveedor
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $responsable
 * @property string|null $email
 * @property string|null $cuit
 * @property string|null $iva_type
 * @property string|null $address
 * @property string|null $city
 * @property string|null $state
 * @property string|null $telephone
 * @property int $active
 *
 * @property Collection|Product[] $products
 *
 * @package App\Models
 */
class Proveedor extends Model
{
	protected $table = 'proveedors';
	public $timestamps = false;

	protected $casts = [
		'active' => 'int'
	];

	protected $fillable = [
		'name',
		'responsable',
		'email',
		'cuit',
		'iva_type',
		'address',
		'city',
		'state',
		'telephone',
		'active',
        'punto_venta'
	];

	public function products()
	{
		return $this->hasMany(Product::class);
	}

	public function displayName()
	{
		$display = '';
		$display .= ($display != '' && !is_null($this->name)) ? ', ' . $this->name : $this->name;
		$display .= ($display != '' && !is_null($this->responsable)) ? ', ' . $this->responsable : $this->responsable;
		return $display;
	}
}
