<?php

namespace App\Services;

use App\Repositories\RoleRepository;

class RoleService
{

    public function __construct(protected RoleRepository $roleRepository)
    {
    }

    function create(array $input)
    {
        return $this->roleRepository->create($input);
    }
    function delete($id){
        return $this->roleRepository->delete($id);
    }
    function update(array $input, $id){
        return $this->roleRepository->update($input, $id);
    }
    function index(){
        return $this->roleRepository->index();
    }
    function find($id){
        return $this->roleRepository->findById($id);
    }
}
