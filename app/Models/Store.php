<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $table = 'stores';

    protected $casts = [
        'cod_fenovo'            => 'int',
        'region_id'             => 'int',
        'storefather_id'        => 'int',
        'billing_amount'        => 'float',
        'lat'                   => 'float',
        'lon'                   => 'float',
        'delivery_percentage'   => 'float',
        'delivery_km'           => 'int',
        'stock_capacity'        => 'int',
        'online_sale'           => 'int',
        'comision_distribucion' => 'float',
        'active'                => 'int',
        'cip'                   => 'int',
    ];

    protected $fillable = [
        'cod_fenovo',
        'razon_social',
        'description',
        'responsable',
        'email',
        'cuit',
        'address',
        'city',
        'state',
        'telephone',
        'iva_type',
        'print_type',
        'store_type',
        'region_id',
        'billing_amount',
        'lat',
        'lon',
        'delivery_percentage',
        'delivery_km',
        'stock_capacity',
        'online_sale',
        'listprice_associate',
        'logistica_express',            // Ingresar porcentaje de flete logistica de distribucion desde la Base
        'punto_venta',                  // Punto de venta para la facturacion
        'habilitado_panama',            // Puede facturar en negro
        'recibe_traslado',              // Puede facturar en negro
        'comision_distribucion',
        'active',
        'cip',                         // codigo impresion panama
        'password',                    // codigo acceso impresion facturas
    ];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, UserStore::class);
    }

    public function displayName()
    {
        $display = '[Cod: ';
        $display .= $this->cod_fenovo;
        $display .= '] ';
        $display .= (is_null($this->description)) ? '' : $this->description;

        return $display;
    }
}
