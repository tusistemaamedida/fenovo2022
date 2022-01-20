<?php

namespace App\Repositories;

use App\Models\ProductType;

class ProducTypeRepository extends BaseRepository {

    public function getModel(){
        return new ProductType();
    }
}
