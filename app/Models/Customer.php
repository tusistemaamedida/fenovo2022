<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Customer
 *
 * @property int         $id
 * @property string|null $cuit
 * @property int|null    $store_id
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
 * @property int         $active
 *
 * @property Store|null $store
 *
 * @package App\Models
 */
class Customer extends Model
{
    protected $table   = 'customers';
    public $timestamps = false;

    protected $casts = [
        'store_id' => 'int',
        'active'   => 'int',
    ];

    protected $fillable = [
        'id',
        'cuit',
        'store_id',
        'bussiness_name',
        'razon_social',
        'responsable',
        'email',
        'iva_type',
        'address',
        'city',
        'state',
        'telephone',
        'listprice_associate',
        'active',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function displayName()
    {
        $display = '';
        $display .= (is_null($this->bussiness_name)) ? '' : $this->bussiness_name;
        $display .= ($display != '' && !is_null($this->razon_social)) ? ', ' . $this->razon_social : $this->razon_social;
        $display .= ($display != '' && !is_null($this->responsable)) ? ', ' . $this->responsable : $this->responsable;

        return $display;
    }
}
