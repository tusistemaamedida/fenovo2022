<?php

namespace App\Repositories;

use App\Models\Senasa;

class SenasaRepository extends BaseRepository
{
    public function getModel()
    {
        return new Senasa();
    }

    protected function selectList()
    {
        return $this->newQuery();
    }

    public function paginate($cant)
    {
        return $this->selectList()
            ->orderBy('id', 'DESC')
            ->paginate($cant);
    }

    public function getOne($id)
    {
        return Senasa::find($id);
    }
}
