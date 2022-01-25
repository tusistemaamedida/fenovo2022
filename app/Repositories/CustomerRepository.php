<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository extends BaseRepository
{

    public function getModel()
    {
        return new Customer();
    }

    protected function selectList()
    {
        return $this->newQuery();
    }

    public function paginate($cant)
    {
        return $this->selectList()
            ->where('active', true)
            ->orderBy('razon_social', 'DESC')
            ->paginate($cant);
    }

    public function getOne($id)
    {
        return Customer::find($id);
    }

    public function search($term){

        return Customer::where('active',true)
                       ->where(function($query) use ($term){
                            $query->orWhere('cuit','LIKE','%'.$term.'%')
                                ->orWhere('responsable','LIKE','%'.$term.'%')
                                ->orWhere('bussiness_name','LIKE','%'.$term.'%')
                                ->orWhere('razon_social','LIKE','%'.$term.'%');
                        })
                        ->get();
    }
}
