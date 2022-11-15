<?php

namespace App\Repository;

abstract class BaseRepo 
{
  
    protected $model;

    public function __construct() {
        $this->setModel();
    }


    abstract public function getModel();


    public function setModel() {
        $this->model = app()->make(
            $this->getModel()
        );
    }


    public function getAll() {
        return $this->model->orderByDesc('id')->get();
    }

    public function getAllandPaginate() {
        return $this->model->orderByDesc('id')->paginate(20);
    }
    public function find($id) {
        $result = $this->model->find($id);
        return $result;
    }

    public function create($attributes = [])
    {
        return $this->model->create($attributes);
    }


    public function update($id, $attributes = [])
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }

        return false;
    }

    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }
}