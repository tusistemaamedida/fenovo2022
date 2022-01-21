<?php

namespace App\Repositories;

use App\Models\ProductCategory;

class ProductCategoryRepository extends BaseRepository {

    public function getModel(){
        return new ProductCategory();
    }
}
