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
}
