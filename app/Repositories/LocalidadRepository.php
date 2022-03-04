<?php

namespace App\Repositories;

use App\Models\Localidad;

class LocalidadRepository extends BaseRepository
{
    public function getModel()
    {
        return new Localidad();
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
        return Localidad::find($id);
    }

    public function getAll()
    {
        return Localidad::all();
    }
}
