<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 *
 * @property int $id
 * @property int $cod_fenovo
 * @property string|null $name
 * @property string|null $description
 * @property string|null $presentation
 * @property string|null $barcode
 * @property string|null $cod_cuenta_compra
 * @property string|null $cod_cuenta_venta
 * @property string|null $cod_proveedor
 * @property string|null $unit_type
 * @property float|null $unit_amount
 * @property float|null $unit_weight
 * @property float|null $net_weight
 * @property float|null $gross_weight
 * @property float|null $stock_min
 * @property int|null $stock_actual
 * @property int|null $stock_sem_min
 * @property int|null $stock_sem_max
 * @property float|null $hight
 * @property float|null $width
 * @property float|null $long
 * @property string|null $type_package
 * @property string|null $unit_package
 * @property int $package_palet
 * @property int $package_row
 * @property string|null $currency
 * @property int $online_sale
 * @property string|null $fragility
 * @property Carbon|null $expiration_date
 * @property Carbon|null $publication_date
 * @property string|null $publication_state
 * @property string|null $publication_log
 * @property int|null $proveedor_id
 * @property int|null $categorie_id
 * @property int|null $type_id
 * @property int|null $senasa_id
 * @property int $active
 * @property int $is_senasa
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 *
 * @property ProductCategory|null $product_category
 * @property Proveedor|null $proveedor
 * @property SenasaDefinition|null $senasa_definition
 * @property ProductType|null $product_type
 * @property Collection|ProductImage[] $product_images
 * @property ProductNutricional $product_nutricional
 * @property ProductPrice $product_price
 *
 * @package App\Models
 */
class Product extends Model
{
	protected $table = 'products';

	protected $casts = [
		'cod_fenovo' => 'int',
		'unit_amount' => 'float',
		'unit_weight' => 'float',
		'net_weight' => 'float',
		'gross_weight' => 'float',
		'stock_min' => 'float',
		'stock_actual' => 'int',
		'stock_sem_min' => 'int',
		'stock_sem_max' => 'int',
		'hight' => 'float',
		'width' => 'float',
		'long' => 'float',
		'package_palet' => 'int',
		'package_row' => 'int',
		'online_sale' => 'int',
		'proveedor_id' => 'int',
		'categorie_id' => 'int',
		'type_id' => 'int',
		'senasa_id' => 'int',
		'active' => 'int',
		'is_senasa' => 'int'
	];

	protected $dates = [
		'expiration_date',
		'publication_date'
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
		'net_weight',
		'gross_weight',
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
		'type_id',
		'senasa_id',
		'active',
		'is_senasa'
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

	public function product_type()
	{
		return $this->belongsTo(ProductType::class, 'type_id');
	}

	public function product_images()
	{
		return $this->hasMany(ProductImage::class,'cod_fenovo');
	}

	public function product_nutricional()
	{
		return $this->hasOne(ProductNutricional::class);
	}

	public function product_price()
	{
		return $this->hasOne(ProductPrice::class);
	}

    public function stock(){
        $stock = 0;
        $movement_product = MovementProduct::where('product_id',$this->id)->latest()->first();
        if($movement_product) $stock = (float) $movement_product->balance;
        return $stock;
    }
}
