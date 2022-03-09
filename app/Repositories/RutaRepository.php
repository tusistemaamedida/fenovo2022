<?php

namespace App\Repositories;

use App\Models\Ruta;

class RutaRepository extends BaseRepository
{

    public function getModel()
    {
        return new Ruta();
    }

    protected function selectList()
    {
        return $this->newQuery()->with([]);
    }

    public function paginate($cant)
    {
        return $this->selectList()
            ->where('active', true)
            ->orderBy('nombre', 'ASC')
            ->paginate($cant);
    }

    public function getOne($id)
    {
        return Ruta::find($id);
    }

    public function getAll()
    {
        return Ruta::with('localidades')->where('active', 1)->orderBy('nombre', 'ASC')->get();
    }
}
