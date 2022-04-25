<?php

namespace App\Repositories;

use App\Models\ProductDescuento;

class DescuentoRepository extends BaseRepository
{
    public function getModel()
    {
        return new ProductDescuento();
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
            ->orderBy('codigo', 'ASC')
            ->paginate($cant);
    }

    public function getOne($id)
    {
        return ProductDescuento::find($id);
    }
}
