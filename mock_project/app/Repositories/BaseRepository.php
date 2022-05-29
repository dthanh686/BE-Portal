<?php

namespace App\Repositories;

abstract class BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    abstract public function getModel();

    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    public function index()
    {
        return $this->model->get();
    }

    public function model()
    {
        return $this->model;
    }
    public function create($attribute)
    {
        return $this->model->create($attribute);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function update($id, $attribute)
    {
        $result = $this->model->find($id);
        $result->fill($attribute);
        return $result->save();
    }

    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }

}
