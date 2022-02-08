<?php

namespace App\Traits;

use App\Models\Proveedor;
use App\Models\Store;
use App\Models\Customer;

trait OriginDataTrait {

    public function origenData($type,$id){
        switch ($type) {
            case 'COMPRA':
                $proveedor = Proveedor::find($id);
                return $proveedor->name . ' ['.$proveedor->cuit.']';
            case 'VENTA':
            case 'TRASLADO':
                $store = Store::find($id);
                return $store->razon_social. ' ['.$store->cuit.'] '. $store->city . ', '. $store->state;
            case 'VENTACLIENTE':
                $customer = Customer::find($id);
                return $customer->razon_social. ' ['.$customer->cuit.'] ';
        }
    }
}
