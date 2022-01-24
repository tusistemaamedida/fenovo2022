<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Store
 * 
 * @property int $id
 * @property int $cod_fenovo
 * @property int|null $region_id
 * @property int|null $storefather_id
 * @property string|null $razon_social
 * @property string|null $description
 * @property string|null $responsable
 * @property string|null $email
 * @property string|null $cuit
 * @property string|null $address
 * @property string|null $city
 * @property string|null $state
 * @property string|null $telephone
 * @property string|null $print_type
 * @property string|null $iva_type
 * @property string|null $store_type
 * @property float|null $billing_amount
 * @property float|null $lat
 * @property float|null $lon
 * @property float|null $delivery_percentage
 * @property int|null $stock_capacity
 * @property int $online_sale
 * @property int $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Region|null $region
 * @property Store|null $store
 * @property Collection|Customer[] $customers
 * @property Collection|Store[] $stores
 * @property Collection|UserLocal[] $user_locals
 *
 * @package App\Models
 */
class Store extends Model
{
	protected $table = 'stores';

	protected $casts = [
		'cod_fenovo' => 'int',
		'region_id' => 'int',
		'storefather_id' => 'int',
		'billing_amount' => 'float',
		'lat' => 'float',
		'lon' => 'float',
		'delivery_percentage' => 'float',
		'stock_capacity' => 'int',
		'online_sale' => 'int',
		'active' => 'int'
	];

	protected $fillable = [
		'cod_fenovo',
		'region_id',
		'storefather_id',
		'razon_social',
		'description',
		'responsable',
		'email',
		'cuit',
		'address',
		'city',
		'state',
		'telephone',
		'print_type',
		'iva_type',
		'store_type',
		'billing_amount',
		'lat',
		'lon',
		'delivery_percentage',
		'stock_capacity',
		'online_sale',
		'active'
	];

	public function region()
	{
		return $this->belongsTo(Region::class, 'region_id');
	}

	public function store()
	{
		return $this->belongsTo(Store::class, 'storefather_id');
	}

	public function customers()
	{
		return $this->hasMany(Customer::class);
	}

	public function stores()
	{
		return $this->hasMany(Store::class, 'storefather_id');
	}

	public function user_locals()
	{
		return $this->hasMany(UserLocal::class);
	}
}
