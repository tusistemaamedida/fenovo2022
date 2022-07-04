<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SessionProduct;

class AuxController extends Controller
{
    //Funcion que me agrega el store id an los session product porque en el traspaso de  lo del circuito a master no estaba
    public function updateListId(){
        $sproducts = SessionProduct::get();
        foreach ($sproducts as $sp) {
            $sp->list_id = $sp->list_id .'_1';
            $sp->save();
        }
    }

}
