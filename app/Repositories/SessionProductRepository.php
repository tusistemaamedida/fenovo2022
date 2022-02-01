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

    public function delete($id){
        return $this->newQuery()->where('id',$id)->delete();
    }
}
