<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StoreResume
 * 
 * @property int $id
 * @property int|null $store_id
 * @property float|null $total_daily_sale
 * @property float|null $stock_capacity
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class StoreResume extends Model
{
	protected $table = 'store_resumes';

	protected $casts = [
		'store_id' => 'int',
		'total_daily_sale' => 'float',
		'stock_capacity' => 'float'
	];

	protected $fillable = [
		'store_id',
		'total_daily_sale',
		'stock_capacity'
	];
}
