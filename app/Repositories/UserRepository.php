<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository {

    public function getModel(){
        return new User();
    }

    protected function selectList(){
        return $this->newQuery()->with([ ]);
    }

    public function paginate($cant){
        return $this->selectList()
            ->orderBy('created_at', 'DESC')
            ->paginate($cant);
    }
    
    public function getOne($id){
        return User::find($id);
    }
}
