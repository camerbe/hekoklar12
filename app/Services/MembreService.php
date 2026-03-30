<?php

namespace App\Services;

use App\IRepositories\IMembreRepository;


class MembreService
{

    public function __construct(protected IMembreRepository $membreRepository)
    {
    }
    function create(array $input)
    {
        return $this->membreRepository->create($input);
    }
    function delete($id){
        return $this->membreRepository->delete($id);
    }
    function find($id){
        return $this->membreRepository->findById($id);
    }
    function update(array $input, $id){
        return $this->membreRepository->update($input, $id);
    }
    function index(){
        return $this->membreRepository->index();
    }
    function getActiveMember(){
        return $this->membreRepository->getActiveMember();
    }
}
