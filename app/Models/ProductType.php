<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductType
 * 
 * @property int $id
 * @property string|null $name
 * @property string $active
 * 
 * @property Collection|Product[] $products
 *
 * @package App\Models
 */
class ProductType extends Model
{
	protected $table = 'product_types';
	public $timestamps = false;

	protected $fillable = [
		'name',
		'active'
	];

	public function products()
	{
		return $this->hasMany(Product::class, 'type_id');
	}
}
