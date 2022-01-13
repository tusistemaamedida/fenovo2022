<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository extends BaseRepository {

    public function getModel(){
        return new Customer();
    }

    protected function selectList(){
        return $this->newQuery()->with(
            ['']
        );
    }

    public function paginate($cant){
        return $this->selectList()
            ->orderBy('created_at', 'DESC')
            ->paginate($cant);
    }
}
