<?php

namespace App\Repositories;

use App\Models\Store;

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
        return Store::all()->sortBy('description');
    }

    public function search($term)
    {
        $ids = null;
        if(\Auth::user()->rol() == 'base'){
            $ids = \Auth::user()->stores->pluck('id');
        }

        return Store::where('active', true)
                    ->when($ids, function ($q, $ids) {
                        $q->whereIn('id', $ids);
                    })
                    ->where(function ($query) use ($term) {
                        $query->orWhere('description', 'LIKE', '%' . $term . '%')
                              ->orWhere('cod_fenovo', 'LIKE', '%' . $term . '%')
                              ->orWhere('responsable', 'LIKE', '%' . $term . '%')
                              ->orWhere('razon_social', 'LIKE', '%' . $term . '%')
                              ->orWhere('cuit', 'LIKE', '%' . $term . '%');
                    })
                    ->get();
    }
}
