<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Movement
 *
 * @property int         $id
 * @property Carbon|null $date
 * @property string      $type
 * @property string|null $from
 * @property string|null $to
 * @property string|null $status
 * @property string|null $voucher_number
 * @property float|null  $flete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|MovementProduct[] $movement_products
 *
 * @package App\Models
 */
class Movement extends Model
{
    protected $table = 'movements';

    public $timestamps = true;

    protected $dates = [
        'date',
    ];

    protected $fillable = [
        'date',
        'type',
        'from',
        'to',
        'status',
        'voucher_number',
        'flete',
    ];

    public function movement_products()
    {
        return $this->hasMany(MovementProduct::class);
    }

    public function movement_salida_products()
    {
        return $this->hasMany(MovementProduct::class)->where('egress', '>', 0);
    }

    public function senasa()
    {
        return $this->belongsToMany(Senasa::class);
    }

    public function origenData($type)
    {
        switch ($type) {
            case 'COMPRA':
                $proveedor = Proveedor::find($this->from);
                return $proveedor->name;
            case 'VENTA':
            case 'TRASLADO':
                $store = Store::find($this->to);
                return $store->razon_social;
            case 'VENTACLIENTE':
                $customer = Customer::find($this->to);
                return $customer->razon_social;
        }
    }
}
