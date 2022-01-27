<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MovementProduct
 * 
 * @property int $id
 * @property int|null $movement_id
 * @property int|null $store_id
 * @property int|null $product_id
 * @property string|null $unit_package
 * @property bool|null $invoice
 * @property float|null $entry
 * @property float|null $egress
 * @property float|null $balance
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Movement|null $movement
 *
 * @package App\Models
 */
class MovementProduct extends Model
{
	protected $table = 'movement_products';

	protected $casts = [
		'movement_id' => 'int',
		'store_id' => 'int',
		'product_id' => 'int',
		'invoice' => 'bool',
		'entry' => 'float',
		'egress' => 'float',
		'balance' => 'float'
	];

	protected $fillable = [
		'movement_id',
		'store_id',
		'product_id',
		'unit_package',
		'invoice',
		'entry',
		'egress',
		'balance'
	];

	public function movement()
	{
		return $this->belongsTo(Movement::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class, 'product_id');
	}
}
