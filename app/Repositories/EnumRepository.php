<?php

namespace App\Repositories;
//Modelo sin uso
use App\Models\Customer;

class EnumRepository extends BaseRepository {

    public function getModel(){
        return new Customer();
    }

    // $type 
    // iva, store, print, role, state, price
    public function getType($type){
        $Enums = json_decode(file_get_contents(storage_path()."/Enums.json"), true);
        return $Enums[$type];
    }
}
