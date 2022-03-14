<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SessionPrices
 *
 * @property int        $id
 * @property int|null   $product_id
 * @property float|null $costproveedor
 * @property float|null $plistproveedor
 * @property float|null $descproveedor
 * @property float|null $costfenovo
 * @property float|null $costdolar
 * @property float|null $mupfenovo
 * @property float|null $tasiva
 * @property float|null $plist0
 * @property float|null $plist0neto
 * @property float|null $plist0iva
 * @property float|null $contribution_fund
 * @property float|null $plist1
 * @property float|null $muplist1
 * @property float|null $plist2
 * @property float|null $muplist2
 * @property float|null $p1tienda
 * @property float|null $mup1
 * @property float|null $descp1
 * @property float|null $p1may
 * @property float|null $mupp1may
 * @property int|null   $cantmay1
 * @property float|null $p2tienda
 * @property float|null $mup2
 * @property float|null $descp2
 * @property float|null $p2may
 * @property float|null $mupp2may
 * @property int|null   $cantmay2
 * @property float|null $comlista1
 * @property float|null $comlista2
 *
 * @property Product|null $product
 *
 * @package App\Models
 */
class SessionPrices extends Model
{
    protected $table   = 'session_prices';
    public $timestamps = true;

    protected $casts = [
        'product_id'        => 'int',
        'costproveedor'     => 'float',
        'plistproveedor'    => 'float',
        'descproveedor'     => 'float',
        'costfenovo'        => 'float',
        'costdolar'         => 'float',
        'mupfenovo'         => 'float',
        'tasiva'            => 'float',
        'plist0'            => 'float',
        'plist0neto'        => 'float',
        'plist0iva'         => 'float',
        'contribution_fund' => 'float',
        'plist1'            => 'float',
        'muplist1'          => 'float',
        'plist2'            => 'float',
        'muplist2'          => 'float',
        'p1tienda'          => 'float',
        'mup1'              => 'float',
        'descp1'            => 'float',
        'p1may'             => 'float',
        'mupp1may'          => 'float',
        'cantmay1'          => 'int',
        'p2tienda'          => 'float',
        'mup2'              => 'float',
        'descp2'            => 'float',
        'p2may'             => 'float',
        'mupp2may'          => 'float',
        'cantmay2'          => 'int',
        'comlista1'         => 'float',
        'comlista2'         => 'float',
    ];

    protected $fillable = [
        'product_id',
        'costproveedor',
        'plistproveedor',
        'descproveedor',
        'costfenovo',
        'costdolar',
        'mupfenovo',
        'tasiva',
        'plist0',
        'plist0neto',
        'plist0iva',
        'contribution_fund',
        'plist1',
        'muplist1',
        'plist2',
        'muplist2',
        'p1tienda',
        'mup1',
        'descp1',
        'p1may',
        'mupp1may',
        'cantmay1',
        'p2tienda',
        'mup2',
        'descp2',
        'p2may',
        'mupp2may',
        'cantmay2',
        'comlista1',
        'comlista2',
        'fecha_actualizacion'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
