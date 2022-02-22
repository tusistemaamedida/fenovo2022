<?php

namespace App\Repositories;

use App\Models\ProductDescuento;

class ProducDescuentoRepository extends BaseRepository
{
    public function getModel()
    {
        return new ProductDescuento();
    }
}
