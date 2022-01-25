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

    public function existCode($code_fenovo){
        return $this->newQuery()->where('cod_fenovo',$code_fenovo)->exists();
    }

    public function search($term){
        return $this->newQuery()->select('id','name','barcode','cod_fenovo','unit_type')
                    ->where('active',true)
                    ->where(function($query) use ($term){
                        $query->orWhere('name','LIKE','%'.$term.'%')
                              ->orWhere('barcode','LIKE','%'.$term.'%')
                              ->orWhere('cod_fenovo','LIKE','%'.$term.'%');
                    })
                    ->get();
    }
}
