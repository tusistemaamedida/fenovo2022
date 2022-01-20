<?php

namespace App\Repositories;

abstract class BaseRepository {

    abstract public function getModel();

    public function newQuery()
    {
        return $this->getModel()->newQuery();
    }

    public function findOrFail($id){
        return $this->newQuery()->findOrFail($id);
    }

    public function getActives($orderBy = 'id', $order = 'ASC'){
        return $this->newQuery()->where('active',true)->orderBy($orderBy ,$order)->get();
    }

    public function update($id,$data){
        return $this->newQuery()->where('id',$id)->update($data);
    }

    public function get($orderBy = 'id', $order = 'ASC'){
        return $this->newQuery()->orderBy($orderBy ,$order)->get();
    }
}
