<?php

namespace App\Repositories;

use App\Models\ActualizacionPrecio;

class ActualizacionRepository extends BaseRepository
{
    public function getModel()
    {
        return new ActualizacionPrecio();
    }

    protected function selectList()
    {
        return $this->newQuery()->with(
            []
        );
    }

    public function paginate($cant)
    {
        return $this->selectList()
            ->orderBy('name', 'DESC')
            ->paginate($cant);
    }

    public function getOne($id)
    {
        return ActualizacionPrecio::find($id);
    }
}
