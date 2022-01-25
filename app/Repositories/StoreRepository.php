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
                'customers'
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
        return Store::all();
    }

    public function search($term){
        return Store::where('active',true)
                    ->where('cod_fenovo','!=',1)
                    ->where(function($query) use ($term){
                        $query->orWhere('cuit','LIKE','%'.$term.'%')
                              ->orWhere('responsable','LIKE','%'.$term.'%')
                              ->orWhere('razon_social','LIKE','%'.$term.'%');
                    })
                    ->get();
    }
}
