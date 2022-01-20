<?php

namespace App\Repositories;

use App\Models\Proveedor;

class ProveedorRepository extends BaseRepository
{

    public function getModel()
    {
        return new Proveedor();
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
            ->where('active', true)
            ->orderBy('name', 'ASC')
            ->paginate($cant);
    }

    public function getOne($id)
    {
        return Proveedor::find($id);
    }
}
