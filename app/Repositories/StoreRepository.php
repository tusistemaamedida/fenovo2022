<?php

namespace App\Repositories;

use App\Models\Store;

class StoreRepository extends BaseRepository {

    public function getModel(){
        return new Store();
    }

    protected function selectList(){
        return $this->newQuery()->with(
            [
                'region',
                'customers'
        ]);
    }

    public function paginate($cant){
        return $this->selectList()
            ->orderBy('created_at', 'DESC')
            ->paginate($cant);
    }
}
