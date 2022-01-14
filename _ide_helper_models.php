<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * Class AdonisSchema
 *
 * @property int $id
 * @property string $name
 * @property int $batch
 * @property Carbon|null $migration_time
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|AdonisSchema newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdonisSchema newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdonisSchema query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdonisSchema whereBatch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdonisSchema whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdonisSchema whereMigrationTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdonisSchema whereName($value)
 */
	class AdonisSchema extends \Eloquent {}
}

namespace App\Models{
/**
 * Class AlicoutaType
 *
 * @property int $id
 * @property int|null $afip_id
 * @property float|null $value
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|AlicoutaType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AlicoutaType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AlicoutaType query()
 * @method static \Illuminate\Database\Eloquent\Builder|AlicoutaType whereAfipId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlicoutaType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlicoutaType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlicoutaType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlicoutaType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AlicoutaType whereValue($value)
 */
	class AlicoutaType extends \Eloquent {}
}

namespace App\Models{
/**
 * Class ApiToken
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $name
 * @property string $type
 * @property string $token
 * @property Carbon|null $expires_at
 * @property Carbon $created_at
 * @property User|null $user
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApiToken whereUserId($value)
 */
	class ApiToken extends \Eloquent {}
}

namespace App\Models{
/**
 * Class ConceptType
 *
 * @property int $id
 * @property int|null $afip_id
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|ConceptType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConceptType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConceptType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConceptType whereAfipId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConceptType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConceptType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConceptType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConceptType whereUpdatedAt($value)
 */
	class ConceptType extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Customer
 *
 * @property int $id
 * @property string|null $cuit
 * @property int|null $store_id
 * @property string|null $bussiness_name
 * @property string|null $razon_social
 * @property string|null $responsable
 * @property string|null $email
 * @property string|null $iva_type
 * @property string|null $address
 * @property string|null $city
 * @property string|null $state
 * @property string|null $telephone
 * @property string|null $listprice_associate
 * @property int $active
 * @property Store|null $store
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereBussinessName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCuit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereIvaType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereListpriceAssociate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereRazonSocial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereResponsable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereTelephone($value)
 */
	class Customer extends \Eloquent {}
}

namespace App\Models{
/**
 * Class DocumentType
 *
 * @property int $id
 * @property int|null $afip_id
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType query()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType whereAfipId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType whereUpdatedAt($value)
 */
	class DocumentType extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Iibb
 *
 * @property int $id
 * @property string|null $state
 * @property float|null $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|Iibb newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Iibb newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Iibb query()
 * @method static \Illuminate\Database\Eloquent\Builder|Iibb whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Iibb whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Iibb whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Iibb whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Iibb whereValue($value)
 */
	class Iibb extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Invoice
 *
 * @property int $id
 * @property int|null $cant_reg
 * @property int|null $movement_id
 * @property string|null $client_name
 * @property string|null $client_address
 * @property string|null $client_cuit
 * @property string|null $client_iva_type
 * @property string|null $voucher_number
 * @property int|null $pto_vta
 * @property int|null $cbte_tipo
 * @property int|null $concepto
 * @property int|null $doc_tipo
 * @property int|null $doc_nro
 * @property int|null $cbte_desde
 * @property int|null $cbte_hasta
 * @property int|null $cbte_fch
 * @property int|null $fch_serv_desde
 * @property int|null $fch_serv_hasta
 * @property int|null $fch_vto_pago
 * @property float|null $imp_total
 * @property float|null $imp_tot_conc
 * @property float|null $imp_neto
 * @property float|null $imp_op_ex
 * @property float|null $imp_iva
 * @property float|null $imp_trib
 * @property float|null $iibb
 * @property string|null $mon_id
 * @property int|null $mon_cotiz
 * @property string|null $ivas
 * @property string|null $cae
 * @property string|null $expiration
 * @property string|null $key
 * @property string|null $error
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCae($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCantReg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCbteDesde($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCbteFch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCbteHasta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCbteTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereClientAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereClientCuit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereClientIvaType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereClientName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereConcepto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDocNro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDocTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereFchServDesde($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereFchServHasta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereFchVtoPago($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereIibb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereImpIva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereImpNeto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereImpOpEx($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereImpTotConc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereImpTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereImpTrib($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereIvas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereMonCotiz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereMonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereMovementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice wherePtoVta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereVoucherNumber($value)
 */
	class Invoice extends \Eloquent {}
}

namespace App\Models{
/**
 * Class IvaCondition
 *
 * @property int $id
 * @property int|null $afip_id
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|IvaCondition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IvaCondition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IvaCondition query()
 * @method static \Illuminate\Database\Eloquent\Builder|IvaCondition whereAfipId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IvaCondition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IvaCondition whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IvaCondition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IvaCondition whereUpdatedAt($value)
 */
	class IvaCondition extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Log
 *
 * @property int $id
 * @property string|null $log
 * @property string|null $origin
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|Log newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Log newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Log query()
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereLog($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereOrigin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Log whereUpdatedAt($value)
 */
	class Log extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Movement
 *
 * @property int $id
 * @property Carbon|null $date
 * @property string $type
 * @property string|null $from
 * @property string|null $to
 * @property string|null $status
 * @property string|null $voucher_number
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Collection|MovementProduct[] $movement_products
 * @package App\Models
 * @property-read int|null $movement_products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Movement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Movement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Movement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Movement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movement whereVoucherNumber($value)
 */
	class Movement extends \Eloquent {}
}

namespace App\Models{
/**
 * Class MovementProduct
 *
 * @property int $id
 * @property int|null $movement_id
 * @property int|null $store_id
 * @property int|null $product_id
 * @property string|null $product_name
 * @property string|null $details
 * @property int|null $pack
 * @property string|null $unity
 * @property float|null $tasiva
 * @property int|null $senasa_id
 * @property string|null $senasa_name
 * @property float|null $unit_price
 * @property string|null $unit_package
 * @property bool|null $invoice
 * @property float|null $entry
 * @property float|null $egress
 * @property float|null $balance
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Movement|null $movement
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereEgress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereEntry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereMovementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct wherePack($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereSenasaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereSenasaName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereTasiva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereUnitPackage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereUnity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MovementProduct whereUpdatedAt($value)
 */
	class MovementProduct extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Permission
 *
 * @property int $id
 * @property string $name
 * @property int|null $rol_id
 * @property string|null $description
 * @property string $key
 * @property bool $active
 * @property Role|null $role
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereRolId($value)
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
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
 * @property ProductCategory|null $product_category
 * @property Proveedor|null $proveedor
 * @property SenasaDefinition|null $senasa_definition
 * @property ProductType|null $product_type
 * @property Collection|ProductImage[] $product_images
 * @property ProductNutricional $product_nutricional
 * @property ProductPrice $product_price
 * @package App\Models
 * @property-read int|null $product_images_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBarcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategorieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCodCuentaCompra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCodCuentaVenta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCodFenovo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCodProveedor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereExpirationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereFragility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereGrossWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereHight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsSenasa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereLong($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereNetWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereOnlineSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePackagePalet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePackageRow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePresentation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereProveedorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePublicationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePublicationLog($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePublicationState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSenasaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStockActual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStockMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStockSemMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStockSemMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTypePackage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUnitAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUnitPackage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUnitType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUnitWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereWidth($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * Class ProductCategory
 *
 * @property int $id
 * @property string|null $name
 * @property string $active
 * @property Collection|Product[] $products
 * @package App\Models
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereName($value)
 */
	class ProductCategory extends \Eloquent {}
}

namespace App\Models{
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
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|ProductException newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductException newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductException query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductException whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductException whereDateFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductException whereDateTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductException whereDateWeek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductException whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductException whereDiscountValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductException whereDiscountValueType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductException whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductException wherePlaceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductException wherePlaceTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductException whereProductLine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductException whereProductLineId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductException whereRuleValue($value)
 */
	class ProductException extends \Eloquent {}
}

namespace App\Models{
/**
 * Class ProductImage
 *
 * @property int $id
 * @property int|null $product_id
 * @property string|null $name
 * @property string $active
 * @property Product|null $product
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductImage whereProductId($value)
 */
	class ProductImage extends \Eloquent {}
}

namespace App\Models{
/**
 * Class ProductNutricional
 *
 * @property int $id
 * @property int|null $product_id
 * @property string|null $ingredients
 * @property float|null $quantity_measure
 * @property string|null $unit_measure
 * @property string|null $measure_reference
 * @property string|null $energy_value
 * @property float|null $energy_porcentage
 * @property string|null $carbohydrates_value
 * @property float|null $carbohydrates_porcentage
 * @property string|null $proteins_value
 * @property float|null $proteins_porcentage
 * @property string|null $total_fat_value
 * @property float|null $total_fat_percentage
 * @property string|null $saturated_fat_value
 * @property float|null $saturated_fat_percentage
 * @property string|null $trans_fat_value
 * @property float|null $trans_fat_percentage
 * @property string|null $fiber_value
 * @property float|null $fiber_percentaje
 * @property string|null $sodioum_value
 * @property float|null $sodioum_percentage
 * @property Product|null $product
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereCarbohydratesPorcentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereCarbohydratesValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereEnergyPorcentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereEnergyValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereFiberPercentaje($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereFiberValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereIngredients($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereMeasureReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereProteinsPorcentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereProteinsValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereQuantityMeasure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereSaturatedFatPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereSaturatedFatValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereSodioumPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereSodioumValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereTotalFatPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereTotalFatValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereTransFatPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereTransFatValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductNutricional whereUnitMeasure($value)
 */
	class ProductNutricional extends \Eloquent {}
}

namespace App\Models{
/**
 * Class ProductPrice
 *
 * @property int $id
 * @property int|null $product_id
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
 * @property int|null $cantmay1
 * @property float|null $p2tienda
 * @property float|null $mup2
 * @property float|null $descp2
 * @property float|null $p2may
 * @property float|null $mupp2may
 * @property int|null $cantmay2
 * @property float|null $comlista1
 * @property float|null $comlista2
 * @property Product|null $product
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereCantmay1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereCantmay2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereComlista1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereComlista2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereContributionFund($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereCostdolar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereCostfenovo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereCostproveedor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereDescp1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereDescp2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereDescproveedor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereMup1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereMup2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereMupfenovo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereMuplist1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereMuplist2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereMupp1may($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereMupp2may($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereP1may($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereP1tienda($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereP2may($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereP2tienda($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice wherePlist0($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice wherePlist0iva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice wherePlist0neto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice wherePlist1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice wherePlist2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice wherePlistproveedor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPrice whereTasiva($value)
 */
	class ProductPrice extends \Eloquent {}
}

namespace App\Models{
/**
 * Class ProductType
 *
 * @property int $id
 * @property string|null $name
 * @property string $active
 * @property Collection|Product[] $products
 * @package App\Models
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|ProductType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductType whereName($value)
 */
	class ProductType extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Proveedor
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $responsable
 * @property string|null $email
 * @property string|null $cuit
 * @property string|null $iva_type
 * @property string|null $firstname
 * @property string|null $lastname
 * @property string|null $address
 * @property string|null $city
 * @property string|null $state
 * @property string|null $telephone
 * @property int $active
 * @property Collection|Product[] $products
 * @package App\Models
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor whereCuit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor whereIvaType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor whereResponsable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proveedor whereTelephone($value)
 */
	class Proveedor extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Regione
 *
 * @property int $id
 * @property string|null $name
 * @property bool $active
 * @property Collection|Store[] $stores
 * @package App\Models
 * @property-read int|null $stores_count
 * @method static \Illuminate\Database\Eloquent\Builder|Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Region query()
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereName($value)
 */
	class Region extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Role
 *
 * @property int $id
 * @property string $name
 * @property bool $active
 * @property Collection|Permission[] $permissions
 * @property Collection|User[] $users
 * @package App\Models
 * @property-read int|null $permissions_count
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Senasa
 *
 * @property int $id
 * @property string|null $movimientos
 * @property string|null $habilitacion_nro
 * @property string|null $patente_nro
 * @property string|null $precintos
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|Senasa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Senasa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Senasa query()
 * @method static \Illuminate\Database\Eloquent\Builder|Senasa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Senasa whereHabilitacionNro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Senasa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Senasa whereMovimientos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Senasa wherePatenteNro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Senasa wherePrecintos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Senasa whereUpdatedAt($value)
 */
	class Senasa extends \Eloquent {}
}

namespace App\Models{
/**
 * Class SenasaDefinition
 *
 * @property int $id
 * @property string|null $product_name
 * @property Collection|Product[] $products
 * @package App\Models
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|SenasaDefinition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SenasaDefinition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SenasaDefinition query()
 * @method static \Illuminate\Database\Eloquent\Builder|SenasaDefinition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SenasaDefinition whereProductName($value)
 */
	class SenasaDefinition extends \Eloquent {}
}

namespace App\Models{
/**
 * Class SessionProduct
 *
 * @property int $id
 * @property string $list_id
 * @property int|null $store_id
 * @property string|null $movement_id
 * @property int|null $product_id
 * @property string|null $product_name
 * @property string|null $unit_type
 * @property float|null $unit_price
 * @property float|null $tasiva
 * @property int|null $senasa_id
 * @property string|null $senasa_name
 * @property string|null $unit_package
 * @property float|null $quantity
 * @property string|null $state
 * @property bool|null $invoice
 * @property float|null $net_weight
 * @property float|null $gross_weight
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereGrossWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereListId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereMovementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereNetWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereSenasaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereSenasaName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereTasiva($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereUnitPackage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereUnitType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SessionProduct whereUpdatedAt($value)
 */
	class SessionProduct extends \Eloquent {}
}

namespace App\Models{
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
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|StockSummary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StockSummary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StockSummary query()
 * @method static \Illuminate\Database\Eloquent\Builder|StockSummary whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockSummary whereDailySale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockSummary whereGrossWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockSummary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockSummary whereNetWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockSummary whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockSummary whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockSummary whereStockActual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockSummary whereStockCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockSummary whereStockMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockSummary whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockSummary whereUnitPackage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockSummary whereUnitType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockSummary whereUpdatedAt($value)
 */
	class StockSummary extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Store
 *
 * @property int $id
 * @property int $cod_fenovo
 * @property int|null $region_id
 * @property int|null $storefather_id
 * @property string|null $fantasy_name
 * @property string|null $razon_social
 * @property string|null $description
 * @property string|null $responsable
 * @property string|null $email
 * @property string|null $cuit
 * @property string|null $address
 * @property string|null $city
 * @property string|null $state
 * @property string|null $telephone
 * @property string|null $print_type
 * @property string|null $iva_type
 * @property string|null $store_type
 * @property float|null $billing_amount
 * @property float|null $lat
 * @property float|null $lon
 * @property float|null $delivery_percentage
 * @property int|null $stock_capacity
 * @property int $online_sale
 * @property int $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Region|null $region
 * @property Store|null $store
 * @property Collection|Customer[] $customers
 * @property Collection|Store[] $stores
 * @property Collection|UserLocal[] $user_locals
 * @package App\Models
 * @property-read int|null $customers_count
 * @property-read int|null $stores_count
 * @property-read int|null $user_locals_count
 * @method static \Illuminate\Database\Eloquent\Builder|Store newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Store newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Store query()
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereBillingAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereCodFenovo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereCuit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereDeliveryPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereFantasyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereIvaType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereLon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereOnlineSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store wherePrintType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereRazonSocial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereResponsable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereStockCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereStoreType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereStorefatherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereUpdatedAt($value)
 */
	class Store extends \Eloquent {}
}

namespace App\Models{
/**
 * Class StoreResume
 *
 * @property int $id
 * @property int|null $store_id
 * @property float|null $total_daily_sale
 * @property float|null $stock_capacity
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|StoreResume newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreResume newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreResume query()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreResume whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreResume whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreResume whereStockCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreResume whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreResume whereTotalDailySale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreResume whereUpdatedAt($value)
 */
	class StoreResume extends \Eloquent {}
}

namespace App\Models{
/**
 * Class User
 *
 * @property int $id
 * @property string|null $name
 * @property string $email
 * @property string|null $username
 * @property int|null $rol_id
 * @property string|null $avatar
 * @property string|null $last_login
 * @property bool $active
 * @property string $password
 * @property string|null $remember_me_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Role|null $role
 * @property Collection|ApiToken[] $api_tokens
 * @property Collection|UserLocal[] $user_locals
 * @package App\Models
 * @property-read int|null $api_tokens_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read int|null $user_locals_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberMeToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * Class UserLocal
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $store_id
 * @property Store|null $store
 * @property User|null $user
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|UserLocal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLocal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLocal query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLocal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLocal whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLocal whereUserId($value)
 */
	class UserLocal extends \Eloquent {}
}

namespace App\Models{
/**
 * Class VoucherType
 *
 * @property int $id
 * @property int|null $afip_id
 * @property string|null $code
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|VoucherType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VoucherType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|VoucherType query()
 * @method static \Illuminate\Database\Eloquent\Builder|VoucherType whereAfipId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VoucherType whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VoucherType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VoucherType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VoucherType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|VoucherType whereUpdatedAt($value)
 */
	class VoucherType extends \Eloquent {}
}

