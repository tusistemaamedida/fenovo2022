<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductCategory
 *
 * @property int $id
 * @property string|null $name
 * @property string $active
 *
 * @property Collection|Product[] $products
 *
 * @package App\Models
 */
class ProductCategory extends Model
{
	protected $table = 'product_categories';
	public $timestamps = false;

	protected $fillable = [
		'name',
        'abrev',
		'active'
	];

	public function products()
	{
		return $this->hasMany(Product::class, 'categorie_id');
	}
}
