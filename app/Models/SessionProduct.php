<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\OriginDataTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SessionProduct
 *
 * @property int         $id
 * @property string      $list_id
 * @property int|null    $store_id
 * @property string|null $movement_id
 * @property int|null    $product_id
 * @property string|null $product_name
 * @property string|null $unit_type
 * @property float|null  $unit_price
 * @property float|null  $tasiva
 * @property int|null    $senasa_id
 * @property string|null $senasa_name
 * @property float|null  $unit_package
 * @property float|null  $quantity
 * @property string|null $state
 * @property bool|null   $invoice
 * @property float|null  $net_weight
 * @property float|null  $gross_weight
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class SessionProduct extends Model
{
    use OriginDataTrait;
    protected $table = 'session_products';

    protected $casts = [
        'store_id'     => 'int',
        'product_id'   => 'int',
        'unit_price'   => 'float',
        'unit_type'    => 'string',
        'unit_package' => 'float',
        'tasiva'       => 'float',
        'senasa_id'    => 'int',
        'quantity'     => 'float',
        'invoice'      => 'bool',
        'net_weight'   => 'float',
        'gross_weight' => 'float',
    ];

    protected $fillable = [
        'list_id',
        'store_id',
        'product_id',
        'unit_price',
        'tasiva',
        'unit_package',
        'unit_type',
        'quantity',
        'invoice',
        'iibb',
        'costo_fenovo',
        'neto',
        'nro_pedido',
        'pausado',
        'circuito',
        'palet',
        'user_id',
        'deposito',
        'desde_deposito',
        'a_deposito'
    ];

    public function producto()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
