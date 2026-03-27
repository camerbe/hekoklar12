<?php

namespace App\Services;

use App\IRepositories\IRepository;
use App\Repositories\TypeArticleRepository;

class TypeArticleService
{

    public function __construct(protected TypeArticleRepository  $typeArticleRepositoty)
    {
    }

    function create(array $input){
        return $this->typeArticleRepositoty->create($input);
    }
    function update(array $input,$id){
        return $this->typeArticleRepositoty->update($input,$id);

    }
    function delete($id){
        return $this->typeArticleRepositoty->delete($id);
    }
    function find($id){
        return $this->typeArticleRepositoty->findById($id);
    }
    function index(){
        return $this->typeArticleRepositoty->index();
    }
}
