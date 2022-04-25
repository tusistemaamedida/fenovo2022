<?php

namespace App\Repositories;

use App\Models\SessionOferta;

class OfertaRepository extends BaseRepository
{
    public function getModel()
    {
        return new SessionOferta();
    }

    protected function selectList()
    {
        return $this->newQuery()->with(['products']);
    }

    public function paginate($cant)
    {
        return $this->selectList()
            ->orderBy('fecha_desde', 'ASC')
            ->orderBy('product_id', 'ASC')
            ->paginate($cant);
    }

    public function getOne($id)
    {
        return SessionOferta::find($id);
    }
}
