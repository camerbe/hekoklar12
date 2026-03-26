<?php

namespace App\Repositories;

use App\IRepositories\IRepository;

class Repository implements IRepository
{
    protected  $model;

    /**
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }


    function create(array $input)
    {
        return $this->model->create($input);
    }

    function delete($id)
    {
        $model=$this->model->findOrFail($id);
        return $model->delete();
    }

    function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    function update(array $input, $id)
    {
        $model=$this->model->findOrFail($id);
        $model->model->update($input);
        return $model;
    }

    function index()
    {
        return $this->model->all();
    }
}
