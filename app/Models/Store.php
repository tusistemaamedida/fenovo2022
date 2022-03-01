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
        'stock_capacity',
        'online_sale',
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
        $display = '';
        $display .= (is_null($this->description)) ? '' : $this->description;
        $display .= ($display != '' && !is_null($this->cod_fenovo)) ? ', ' . $this->cod_fenovo : $this->cod_fenovo;
        return $display;
    }
}
