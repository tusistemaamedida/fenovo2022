<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductImage
 * 
 * @property int $id
 * @property int|null $product_id
 * @property string|null $name
 * @property string $active
 * 
 * @property Product|null $product
 *
 * @package App\Models
 */
class ProductImage extends Model
{
	protected $table = 'product_images';
	public $timestamps = false;

	protected $casts = [
		'product_id' => 'int'
	];

	protected $fillable = [
		'product_id',
		'name',
		'active'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
