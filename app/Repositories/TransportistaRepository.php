<?php

namespace App\Repositories;

use App\Models\Transportista;

class TransportistaRepository extends BaseRepository
{
    public function getModel()
    {
        return new Transportista();
    }

    protected function selectList()
    {
        return $this->newQuery()->with([]);
    }

    public function paginate($cant)
    {
        return $this->selectList()
            ->orderBy('nombre', 'ASC')
            ->paginate($cant);
    }

    public function getOne($id)
    {
        return Transportista::find($id);
    }

    public function getAll()
    {
        return Transportista::where('active', 1)->orderBy('nombre', 'ASC')->get();
    }
}
