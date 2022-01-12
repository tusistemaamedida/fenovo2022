<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductNutricional
 * 
 * @property int $id
 * @property int|null $product_id
 * @property string|null $ingredients
 * @property float|null $quantity_measure
 * @property string|null $unit_measure
 * @property string|null $measure_reference
 * @property string|null $energy_value
 * @property float|null $energy_porcentage
 * @property string|null $carbohydrates_value
 * @property float|null $carbohydrates_porcentage
 * @property string|null $proteins_value
 * @property float|null $proteins_porcentage
 * @property string|null $total_fat_value
 * @property float|null $total_fat_percentage
 * @property string|null $saturated_fat_value
 * @property float|null $saturated_fat_percentage
 * @property string|null $trans_fat_value
 * @property float|null $trans_fat_percentage
 * @property string|null $fiber_value
 * @property float|null $fiber_percentaje
 * @property string|null $sodioum_value
 * @property float|null $sodioum_percentage
 * 
 * @property Product|null $product
 *
 * @package App\Models
 */
class ProductNutricional extends Model
{
	protected $table = 'product_nutricionals';
	public $timestamps = false;

	protected $casts = [
		'product_id' => 'int',
		'quantity_measure' => 'float',
		'energy_porcentage' => 'float',
		'carbohydrates_porcentage' => 'float',
		'proteins_porcentage' => 'float',
		'total_fat_percentage' => 'float',
		'saturated_fat_percentage' => 'float',
		'trans_fat_percentage' => 'float',
		'fiber_percentaje' => 'float',
		'sodioum_percentage' => 'float'
	];

	protected $fillable = [
		'product_id',
		'ingredients',
		'quantity_measure',
		'unit_measure',
		'measure_reference',
		'energy_value',
		'energy_porcentage',
		'carbohydrates_value',
		'carbohydrates_porcentage',
		'proteins_value',
		'proteins_porcentage',
		'total_fat_value',
		'total_fat_percentage',
		'saturated_fat_value',
		'saturated_fat_percentage',
		'trans_fat_value',
		'trans_fat_percentage',
		'fiber_value',
		'fiber_percentaje',
		'sodioum_value',
		'sodioum_percentage'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
