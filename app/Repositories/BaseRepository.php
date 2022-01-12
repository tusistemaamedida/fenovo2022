<?php

namespace App\Repositories;

abstract class BaseRepository {

    abstract public function getModel();

    public function newQuery()
    {
        return $this->getModel()->newQuery();
    }

    public function findOrFail($id)
    {
        return $this->newQuery()->findOrFail($id);
    }

}
