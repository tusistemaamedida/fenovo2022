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

    public function search($term){

        return Invoice::whereNotNull('cae')->where('voucher_number','LIKE','%'.$term.'%')->get();
    }

    public function getByVoucherNumber($voucher_number){
        return $this->newQuery()->where('voucher_number',$voucher_number)->first();
    }
}
