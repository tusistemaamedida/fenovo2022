<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $casts = [
        'cod_fenovo'       => 'int',
        'unit_amount'      => 'float',
        'unit_weight'      => 'float',
        'porcentaje_bruto' => 'float',
        'stock_min'        => 'float',
        'stock_actual'     => 'int',
        'stock_sem_min'    => 'int',
        'stock_sem_max'    => 'int',
        'hight'            => 'float',
        'width'            => 'float',
        'long'             => 'float',
        'package_palet'    => 'int',
        'package_row'      => 'int',
        'online_sale'      => 'int',
        'proveedor_id'     => 'int',
        'categorie_id'     => 'int',
        'type_id'          => 'int',
        'senasa_id'        => 'int',
        'active'           => 'int',
        'is_senasa'        => 'int',
    ];

    protected $dates = [
        'expiration_date',
        'publication_date',
    ];

    protected $fillable = [
        'cod_fenovo',
        'name',
        'description',
        'barcode',
        'cod_cuenta_compra',
        'cod_cuenta_venta',
        'cod_proveedor',
        'unit_type',
        'unit_amount',
        'unit_weight',
        'porcentaje_bruto',
        'stock_min',
        'stock_actual',
        'stock_sem_min',
        'stock_sem_max',
        'hight',
        'width',
        'long',
        'unit_package',
        'package_palet',
        'package_row',
        'currency',
        'online_sale',
        'fragility',
        'expiration_date',
        'publication_date',
        'publication_state',
        'publication_log',
        'proveedor_id',
        'categorie_id',
        'cod_descuento',
        'senasa_id',
        'active',
        'is_senasa',
    ];

    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class, 'categorie_id');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function senasa_definition()
    {
        return $this->belongsTo(SenasaDefinition::class, 'senasa_id');
    }

    public function senasa()
    {
        $senasa = SenasaDefinition::find($this->senasa_id);
        return ($senasa) ? $senasa->product_name : null;
    }

    public function product_descuento()
    {
        return $this->belongsTo(ProductDescuento::class, 'cod_descuento');
    }

    public function product_images()
    {
        return $this->hasMany(ProductImage::class, 'cod_fenovo');
    }

    public function product_nutricional()
    {
        return $this->hasOne(ProductNutricional::class);
    }

    public function product_price()
    {
        return $this->hasOne(ProductPrice::class);
    }

    public function stock($unit_package = null, $store_id = 1)
    {
        $stock            = 0.0;
        $movement_product = MovementProduct::where('product_id', $this->id)
                                            ->where('store_id', $store_id)
                                            ->when($unit_package, function ($q, $unit_package) {
                                                $q->where('unit_package', $unit_package);
                                            })
                                            ->latest()
                                            ->first();
        if ($movement_product) {
            $stock = (float) $movement_product->balance;
        }
        return $stock;
    }
}
