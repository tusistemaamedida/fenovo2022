<?php

namespace App\Repositories;

use App\Models\SessionProduct;
use App\Models\Store;

class SessionProductRepository extends BaseRepository
{
    public function getModel()
    {
        return new SessionProduct();
    }

    public function getByListId($list_id)
    {
        return $this->newQuery()->where('list_id', $list_id)->with('producto')->orderBy('product_id')->get();
    }

    public function getByListIdAndProduct($list_id, $product_id)
    {
        return $this->newQuery()->where('list_id', $list_id)->where('product_id', $product_id)->first();
    }

    public function delete($id)
    {
        return $this->newQuery()->where('id', $id)->delete();
    }

    public function getCantidadTotalDeBultosByListId($product_id, $unit_package = null, $list_id)
    {
        return $this->newQuery()->where('product_id', $product_id)
                                ->where('list_id', $list_id)
                                ->when($unit_package, function ($q, $unit_package) {
                                    $q->where('unit_package', $unit_package);
                                })
                                ->sum('quantity');
    }

    public function getCantidadTotalDeBultos($product_id, $unit_package = null, $store_id = 1)
    {
        return $this->newQuery()->where('product_id', $product_id)
                                ->where('store_id', $store_id)
                                ->when($unit_package, function ($q, $unit_package) {
                                    $q->where('unit_package', $unit_package);
                                })
                                ->sum('quantity');
    }

    public function updateOrCreate($data)
    {
        return $this->newQuery()->updateOrCreate(
            [
                'product_id'   => $data['product_id'],
                'unit_package' => $data['unit_package'],
                'store_id'     => $data['store_id'],
                'list_id'      => $data['list_id'],
            ],
            $data
        );
    }

    public function deleteList($list_id)
    {
        return $this->newQuery()->where('list_id', $list_id)->delete();
    }

    public function groupBy($group)
    {
        if (\Auth::user()->rol() == 'superadmin' || \Auth::user()->rol() == 'admin') {
            return SessionProduct::select()->where('list_id', 'not like', '%DEVOLUCION_%')->orderBy('updated_at', 'DESC')->get()->unique($group);
        }
        return SessionProduct::select()->where('list_id', 'not like', '%DEVOLUCION_%')->where('store_id', \Auth::user()->store_active)->orderBy('updated_at', 'DESC')->get()->unique($group);
    }

    public function getFlete($list_id)
    {
        $cadena = explode('_', $list_id);
        if (isset($cadena[0]) && ($cadena[0] == 'VENTA')) {
            $store = Store::find($cadena[1]);
            $km    = $store->delivery_km;
            return $km;
        }
        return '0';
    }

    public function deleteDevoluciones()
    {
        return $this->newQuery()->where('list_id', 'like', '%DEVOLUCION_%')->delete();
    }

    public function deleteDebitos()
    {
        return $this->newQuery()->where('list_id', 'like', '%DEBITO%')->delete();
    }
}
