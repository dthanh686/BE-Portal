<?php

namespace App\Services;

abstract class BaseService
{
    protected $repo;

    public function __construct()
    {
        $this->setRepository();
    }

    abstract public function getRepository();

    public function setRepository()
    {
        $this->repo = app()->make(
            $this->getRepository()
        );
    }

    public function create($data = [])
    {
        return $this->repo->create($data);
    }

    public function find($id)
    {
        return $this->repo->find($id);
    }

    public function update ($id, $data)
    {
        return $this->repo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repo->delete($id);
    }
}
