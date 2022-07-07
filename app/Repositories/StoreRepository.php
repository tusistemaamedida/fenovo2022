<?php

namespace App\Repositories;

use App\Models\Store;
use Illuminate\Support\Facades\Auth;

class StoreRepository extends BaseRepository
{
    public function getModel()
    {
        return new Store();
    }

    protected function selectList()
    {
        return $this->newQuery()->with(
            [
                'region',
                'customers',
            ]
        );
    }

    public function paginate($cant)
    {
        return $this->selectList()
            ->where('active', true)
            ->orderBy('created_at', 'DESC')
            ->paginate($cant);
    }

    public function getOne($id)
    {
        return Store::find($id);
    }

    public function getAll()
    {
        return Store::orderBy('description', 'ASC')->get();
    }

    public function search($term, $is_base = false)
    {
        $ids = null;
        if (Auth::user()->rol() == 'base') {
            $ids = Auth::user()->stores->pluck('id');
        }

        $store_type = ($is_base) ? 'B' : null;

        return Store::where('active', true)
                    ->when($ids, function ($q, $ids) {
                        $q->whereIn('id', $ids);
                    })
                    ->when($store_type, function ($q, $store_type) {
                        $q->where('store_type', $store_type);
                    })
                    ->where(function ($query) use ($term) {
                        $query->orWhere('description', 'LIKE', '%' . $term . '%')
                              ->orWhere('cod_fenovo', 'LIKE', '%' . $term . '%')
                              ->orWhere('cuit', 'LIKE', '%' . $term . '%');
                    })
                    ->get();
    }
}
