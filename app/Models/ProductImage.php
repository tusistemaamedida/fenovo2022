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
 * @property int|null $cod_fenovo
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
		'cod_fenovo' => 'int'
	];

	protected $fillable = [
		'cod_fenovo',
		'name',
		'active'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
