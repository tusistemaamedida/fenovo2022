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
        $p = $this->newQuery()->where('id',$id)->first();
        return $p->update($data);
    }

    public function updateWhere($column,$value,$data){
        $p = $this->newQuery()->where($column,$value)->first();
        $p->update($data);
        return $p->getChanges();
    }

    public function delete($id){
        return $this->newQuery()->where('id',$id)->delete();
    }

    public function deleteWhere($column,$value){
        return $this->newQuery()->where($column,$value)->delete();
    }

    public function get($orderBy = 'id', $order = 'ASC'){
        return $this->newQuery()->orderBy($orderBy ,$order)->get();
    }

    public function create($data){
        return $this->getModel()->create($data);
    }

    public function all(){
        return $this->getModel()->all();
    }

    public function getById($id){
        return $this->newQuery()->where('id' ,$id)->first();
    }

    public function fill($id,$data){
        $obj = $this->newQuery()->where('id',$id)->first();
        $obj->fill($data);
        return $obj->save();
    }
}
