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
        'cod_fenovo'          => 'int',
        'region_id'           => 'int',
        'storefather_id'      => 'int',
        'billing_amount'      => 'float',
        'lat'                 => 'float',
        'lon'                 => 'float',
        'delivery_percentage' => 'float',
        'delivery_km'         => 'int',
        'stock_capacity'      => 'int',
        'online_sale'         => 'int',
        'active'              => 'int',
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
        'active',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, UserStore::class);
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
