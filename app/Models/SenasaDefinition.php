<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SenasaDefinition
 * 
 * @property int $id
 * @property string|null $product_name
 * 
 * @property Collection|Product[] $products
 *
 * @package App\Models
 */
class SenasaDefinition extends Model
{
	protected $table = 'senasa_definitions';
	public $timestamps = false;

	protected $fillable = [
		'product_name'
	];

	public function products()
	{
		return $this->hasMany(Product::class, 'senasa_id');
	}
}
