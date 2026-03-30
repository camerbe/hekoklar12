<?php

namespace App\Services;

use App\IRepositories\IMessageRepository;

class MessageService
{

    public function __construct(protected IMessageRepository $messageRepository)
    {
    }

    function create(array $input){
        return $this->messageRepository->create($input);
    }

    function delete($id){
        return $this->messageRepository->delete($id);
    }
    function update(array $input, $id){
        return $this->messageRepository->update($input, $id);
    }
    function index(){
        return $this->messageRepository->index();
    }

    function find($id){
        return $this->messageRepository->findById($id);
    }
    function getCurrentAGMessage(){
        return $this->messageRepository->getCurrentAGMessage();
    }
}
