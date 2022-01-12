<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends BaseRepository {

    public function getModel(){
        return new Product();
    }

    protected function selectList(){
        return $this->newQuery()->with([
            'product_category',
            'proveedor',
            'senasa_definition',
            'product_type',
            'product_images',
            'product_nutricional',
            'product_price'
        ]);
    }

    public function paginate($cant){
        return $this->selectList()
            ->orderBy('created_at', 'DESC')
            ->paginate($cant);
    }
}
