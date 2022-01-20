<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{

    public function getModel()
    {
        return new User();
    }

    protected function selectList()
    {
        return $this->newQuery();
    }

    public function paginate($cant)
    {
        return $this->selectList()
            ->where('active', true)
            ->orderBy('created_at', 'DESC')
            ->paginate($cant);
    }

    public function getAll()
    {
        return $this->newQuery()->get();
    }

    public function getOne($id)
    {
        return User::find($id);
    }
}
