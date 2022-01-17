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

    public function getActives(){
        return $this->newQuery()->where('active',true)->get();
    }

    public function update($id,$data){
        return $this->newQuery()->where('id',$id)->update($data);
    }

    public function create($data){
        return $this->getModel()->create($data);
    }

}
