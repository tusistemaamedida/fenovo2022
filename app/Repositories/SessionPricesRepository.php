<?php

namespace App\Repositories;

use App\Models\SessionPrices;

class SessionPricesRepository extends BaseRepository
{
    public function getModel()
    {
        return new SessionPrices();
    }

    protected function selectList()
    {
        return $this->newQuery()->with([]);
    }

    public function paginate($cant)
    {
        return $this->selectList()
            ->orderBy('name', 'DESC')
            ->paginate($cant);
    }

    public function getOne($id)
    {
        return SessionPrices::find($id);
    }

    public function getBy($column,$value){
        return SessionPrices::where($column,$value)->get();
    }
}
