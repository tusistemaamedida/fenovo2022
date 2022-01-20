<?php

namespace App\Repositories;

use App\Models\Region;

class RegionRepository extends BaseRepository
{

    public function getModel()
    {
        return new Region();
    }

    protected function selectList()
    {
        return $this->newQuery()->with([]);
    }

    public function paginate($cant)
    {
        return $this->selectList()
            ->where('active', true)
            ->orderBy('name', 'ASC')
            ->paginate($cant);
    }

    public function getOne($id)
    {
        return Region::find($id);
    }

    public function getAll()
    {
        return Region::all()->where('active', 1);
    }
}
