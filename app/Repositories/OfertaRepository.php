<?php

namespace App\Repositories;

use App\Models\ProductOferta;

class OfertaRepository extends BaseRepository
{
    public function getModel()
    {
        return new ProductOferta();
    }

    protected function selectList()
    {
        return $this->newQuery()->with(['products']);
    }

    public function paginate($cant)
    {
        return $this->selectList()
            ->orderBy('fechadesde', 'ASC')
            ->orderBy('product_id', 'ASC')
            ->paginate($cant);
    }

    public function getOne($id)
    {
        return ProductOferta::find($id);
    }
}
