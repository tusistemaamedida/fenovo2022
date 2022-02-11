<?php

namespace App\Repositories;

use App\Models\Invoice;

class InvoicesRepository extends BaseRepository {

    public function getModel(){
        return new Invoice();
    }

    public function getByMovement($id){
        return $this->newQuery()->where('movement_id',$id)->first();
    }
}
