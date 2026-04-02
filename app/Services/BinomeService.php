<?php

namespace App\Services;

use App\Repositories\BinomeRepository;

class BinomeService
{

    public function __construct(protected BinomeRepository $binomeRepository)
    {
    }

    function create(array $input)
    {
        return $this->binomeRepository->create($input);
    }
    function delete($id){
        return $this->binomeRepository->delete($id);
    }
    function find($id){
        return $this->binomeRepository->findById($id);
    }
    function update(array $input, $id){
        return $this->binomeRepository->update($input, $id);
    }
    function index(){
        return $this->binomeRepository->index();
    }
}
