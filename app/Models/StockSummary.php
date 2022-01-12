<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StockSummary
 * 
 * @property int $id
 * @property int|null $product_id
 * @property int|null $store_id
 * @property float|null $daily_sale
 * @property float|null $stock_min
 * @property float|null $stock_actual
 * @property float|null $net_weight
 * @property float|null $gross_weight
 * @property string|null $unit_type
 * @property string|null $unit_package
 * @property string|null $product_name
 * @property float|null $stock_capacity
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class StockSummary extends Model
{
	protected $table = 'stock_summaries';

	protected $casts = [
		'product_id' => 'int',
		'store_id' => 'int',
		'daily_sale' => 'float',
		'stock_min' => 'float',
		'stock_actual' => 'float',
		'net_weight' => 'float',
		'gross_weight' => 'float',
		'stock_capacity' => 'float'
	];

	protected $fillable = [
		'product_id',
		'store_id',
		'daily_sale',
		'stock_min',
		'stock_actual',
		'net_weight',
		'gross_weight',
		'unit_type',
		'unit_package',
		'product_name',
		'stock_capacity'
	];
}
