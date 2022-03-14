<?php

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

    public function session_prices()
    {
        return $this->hasMany(SessionPrices::class)->groupBy('fecha_actualizacion');
    }

    public function stock($unit_package = null, $entidad_id = 1, $entidad_tipo = 'S')
    {
        $stock = 0.0;
        // Buscar el ultimo movimiento
        $movement_product = MovementProduct::where('product_id', $this->id)
            ->where('entidad_id', $entidad_id)
            ->where('entidad_tipo', $entidad_tipo)
            ->when($unit_package, function ($q, $unit_package) {
                $q->where('unit_package', $unit_package);
            })
            ->orderBy('id', 'DESC')
            ->first();

        if ($movement_product) {
            $stock = (float)$movement_product->balance;
        }

        // Buscar en la session iniciadas
        $subtotal         = 0.0;
        $session_products = SessionProduct::where('product_id', $this->id)->where('store_id', $entidad_id)->get();
        foreach ($session_products as $session_product) {
            $subtotal = $subtotal + ($session_product->unit_package * $session_product->quantity * $this->unit_weight);
        }
        if ($session_products) {
            $stock = $stock - $subtotal;
        }

        return $stock;
    }
}
