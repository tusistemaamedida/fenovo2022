<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductException
 * 
 * @property int $id
 * @property string|null $place_type
 * @property int|null $place_type_id
 * @property string|null $product_line
 * @property int|null $product_line_id
 * @property float|null $discount_value
 * @property string|null $discount_value_type
 * @property string|null $discount_type
 * @property float|null $rule_value
 * @property string|null $date_week
 * @property Carbon|null $date_from
 * @property Carbon|null $date_to
 * @property int|null $active
 *
 * @package App\Models
 */
class ProductException extends Model
{
	protected $table = 'product_exceptions';
	public $timestamps = false;

	protected $casts = [
		'place_type_id' => 'int',
		'product_line_id' => 'int',
		'discount_value' => 'float',
		'rule_value' => 'float',
		'active' => 'int'
	];

	protected $dates = [
		'date_from',
		'date_to'
	];

	protected $fillable = [
		'place_type',
		'place_type_id',
		'product_line',
		'product_line_id',
		'discount_value',
		'discount_value_type',
		'discount_type',
		'rule_value',
		'date_week',
		'date_from',
		'date_to',
		'active'
	];
}
