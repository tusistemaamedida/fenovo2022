<?php

namespace App\Repositories;

use App\Models\Vehiculo;

class VehiculoRepository extends BaseRepository
{
    public function getModel()
    {
        return new Vehiculo();
    }

    protected function selectList()
    {
        return $this->newQuery()->with([]);
    }

    public function paginate($cant)
    {
        return $this->selectList()
            ->orderBy('tipo', 'ASC')
            ->paginate($cant);
    }

    public function getOne($id)
    {
        return Vehiculo::find($id);
    }

    public function getAll()
    {
        return Vehiculo::where('active', 1)->orderBy('tipo', 'ASC')->get();
    }
}
