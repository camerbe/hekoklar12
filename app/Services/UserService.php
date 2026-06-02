<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{

    public function __construct(protected UserRepository $userRepository)
    {
    }
    function create(array $input){
        return $this->userRepository->create($input);
    }
    function delete($id){
        return $this->userRepository->delete($id);
    }
    function update(array $input, $id){
        return $this->userRepository->update($input, $id);
    }
    function index(){
        return $this->userRepository->index();
    }
    function find($id){
        return $this->userRepository->findById($id);
    }
    function getTeam(){
        return $this->userRepository->getTeam();
    }
}

