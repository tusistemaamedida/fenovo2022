<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MovementTemp extends Model
{
    protected $table = 'movementstemp';

    public $timestamps = true;

    protected $dates = [
        'date',
    ];

    protected $fillable = [
        'date',
        'type',
        'subtype',
        'from',
        'to',
        'status',
        'voucher_number',
        'flete',
        'flete_invoice',
        'orden',
        'exported',
        'user_id',
        'observacion',
    ];

    public function movement_products()
    {
        return $this->hasMany(MovementProductTemp::class, 'movement_id');
    }

    public function movement_salida_products()
    {
        return $this->hasMany(MovementProductTemp::class, 'movement_id')->where('egress', '>', 0);
    }

    public function movement_ingreso_products()
    {
        return $this->hasMany(MovementProductTemp::class, 'movement_id')->where('entry', '>', 0);
    }

    public function totalKgrs()
    {
        $kgrs = 0;

        $arrIngreso = ['COMPRA', 'DEVOLUCION', 'DEVOLUCIONCLIENTE'];
        $arrEgreso  = ['VENTA', 'VENTACLIENTE', 'TRASLADO'];
        $mp         = (in_array($this->type, $arrIngreso)) ? $this->movement_ingreso_products : $this->movement_salida_products;

        foreach ($mp as $m) {
            $kgrs += $m->product->unit_weight * $m->unit_package * $m->bultos;
        }

        return round($kgrs, 2);
    }

    public function From($type, $returnObject = false)
    {
        switch ($type) {
            case 'COMPRA':
                $Proveedor = Proveedor::find($this->from);
                if ($returnObject) {
                    return $Proveedor;
                }
                return $Proveedor->name;
            case 'VENTA':
            case 'TRASLADO':
            case 'DEVOLUCION':
            case 'VENTACLIENTE':
                $Store = Store::find($this->from);
                if ($returnObject) {
                    return $Store;
                }
                return $Store->description;
            case 'DEVOLUCIONCLIENTE':
                $customer = Customer::find($this->to);
                return $customer->razon_social;
        }
    }

    public function To($type, $returnObject = false)
    {
        switch ($type) {
            case 'COMPRA':
            case 'VENTA':
            case 'TRASLADO':
            case 'DEVOLUCION':
                $Store = Store::find($this->to);
                if ($returnObject) {
                    return $Store;
                }
                return $Store->description;
            case 'DEVOLUCIONCLIENTE':
                $Store = Store::find($this->from);
                if ($returnObject) {
                    return $Store;
                }
                return $Store->description;
            case 'VENTACLIENTE':
                $Customer = Customer::find($this->to);
                if ($returnObject) {
                    return $Customer;
                }
                return $Customer->razon_social;
        }
    }

    public function origenData($type)
    {
        $typeTo = $this->to;
        if (($type == 'TRASLADO' && Auth::user()->store_active == $typeTo) || $type == 'VENTA' && Auth::user()->store_active == $typeTo) {
            $typeTo = $this->from;
        }

        switch ($type) {
            case 'COMPRA':
                $proveedor = Proveedor::find($this->from);
                return $proveedor->name;
            case 'VENTA':
            case 'TRASLADO':
            case 'DEVOLUCION':
            case 'DEBITO':
                $store = Store::find($typeTo);
                return $store->description;
            case 'VENTACLIENTE':
            case 'DEBITOCLIENTE':
            case 'DEVOLUCIONCLIENTE':
                $customer = Customer::find($typeTo);
                return $customer->razon_social;
        }
    }
}
