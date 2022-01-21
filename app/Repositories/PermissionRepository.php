<?php

namespace App\Repositories;

use Spatie\Permission\Models\Permission;

class PermissionRepository extends BaseRepository
{

    public function getModel()
    {
        return new Permission();
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
            ->orderBy('name', 'DESC')
            ->paginate($cant);
    }

    public function getOne($id)
    {
        return Permission::find($id);
    }
}
