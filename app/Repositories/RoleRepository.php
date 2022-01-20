<?php

namespace App\Repositories;

use App\Models\Role;

class RoleRepository extends BaseRepository
{

    public function getModel()
    {
        return new Role();
    }

    protected function selectList()
    {
        return $this->newQuery()->with(
            []
        );
    }

    public function paginate($cant)
    {
        return $this->selectList()
            ->where('active', true)
            ->orderBy('name', 'DESC')
            ->paginate($cant);
    }

    public function getOne($id)
    {
        return Role::find($id);
    }
}
