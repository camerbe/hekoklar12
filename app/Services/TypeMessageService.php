<?php

namespace App\Services;

use App\Repositories\Repository;

class TypeMessageService
{

    public function __construct(protected Repository $typeMessageRepository)
    {
    }

    function create(array $input){
        return $this->typeMessageRepository->create($input);

    }
    function delete($id){
        return $this->typeMessageRepository->delete($id);
    }

    function update(array $input,$id){
        return $this->typeMessageRepository->update($input,$id);
    }
    function find($id){
         return $this->typeMessageRepository->findById($id);
    }
    function index(){
        //dd($this->typeMessageRepository->index());
        return $this->typeMessageRepository->index();
    }

}
