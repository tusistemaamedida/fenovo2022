<?php

namespace App\Repositories;

use App\Models\ProductPrice;

class ProductPriceRepository extends BaseRepository {

    public function getModel(){
        return new ProductPrice();
    }
}
