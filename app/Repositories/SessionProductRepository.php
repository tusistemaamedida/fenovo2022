<?php

namespace App\Repositories;

use App\Models\SessionProduct;

class SessionProductRepository extends BaseRepository
{
    public function getModel(){
        return new SessionProduct();
    }

    public function getByListId($list_id){
        return $this->newQuery()->where('list_id',$list_id)->with('producto')->get();
    }

    public function getByListIdAndProduct($list_id,$product_id){
        return $this->newQuery()->where('list_id',$list_id)->where('product_id',$product_id)->first();
    }

    public function delete($id){
        return $this->newQuery()->where('id',$id)->delete();
    }

    public function getCantidadTotalDeBultos($product_id,$unit_package = null,$store_id = 1){
        return $this->newQuery()->where('product_id',$product_id)
                                ->where('store_id',$store_id)
                                ->when($unit_package, function ($q, $unit_package) {
                                    $q->where('unit_package', $unit_package);
                                })
                                ->sum('quantity');
    }

    public function updateOrCreate($data){
        return $this->newQuery()->updateOrCreate(
            [
                'product_id' => $data['product_id'],
                'unit_package' => $data['unit_package'],
                'store_id' => $data['store_id'],
                'list_id' => $data['list_id']
            ],
            $data
        );
    }

    public function deleteList($list_id){
        return $this->newQuery()->where('list_id',$list_id)->delete();
    }

    public function groupBy($group){
        return SessionProduct::groupBy($group)->get();
    }
}
