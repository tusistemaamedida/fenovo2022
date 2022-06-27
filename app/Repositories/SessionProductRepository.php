<?php

namespace App\Repositories;

use App\Models\SessionProduct;
use App\Models\Store;

use DB;

class SessionProductRepository extends BaseRepository
{
    public function getModel()
    {
        return new SessionProduct();
    }

    public function getByListId($list_id)
    {
        return $this->newQuery()->where('list_id', $list_id)->whereNull('pausado')->with('producto')->orderBy('product_id')->get();
    }

    public function getByListIdAndProduct($list_id, $product_id)
    {
        return $this->newQuery()->where('list_id', $list_id)->where('product_id', $product_id)->first();
    }

    public function delete($id)
    {
        return $this->newQuery()->where('id', $id)->delete();
    }

    public function getCantidadTotalDeBultosByListId($product_id, $unit_package = null, $list_id, $circuito)
    {
        return $this->newQuery()->where('product_id', $product_id)
                                ->where('list_id', $list_id)
                                ->where('circuito',$circuito)
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
                'circuito'     => $data['circuito'],
                'pausado'      => null
            ],
            $data
        );
    }

    public function deleteList($list_id)
    {
        return $this->newQuery()->where('list_id', $list_id)->whereNull('pausado')->delete();
    }

    public function groupBy($group)
    {
        return SessionProduct::select('*', DB::raw("COUNT(id) as total"))
                                 ->where('store_id',\Auth::user()->store_active)
                                 ->where('list_id', 'not like', '%DEVOLUCION_%')
                                 ->orderBy('updated_at', 'DESC')
                                 ->groupBy('list_id','pausado')
                                 ->get();
    }

    public function getFlete($list_id)
    {
        $cadena = explode('_', $list_id);
        if (isset($cadena[0]) && (($cadena[0] == 'VENTA') or ($cadena[0] == 'TRASLADO'))) {
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
