<?php

namespace App\Services;

use App\Repositories\VideoRepository;

class VideoService
{

    public function __construct(protected VideoRepository $videoRepository)
    {
    }

    function create(array $input)
    {
        return $this->videoRepository->create($input);
    }
    function delete($id){
        return $this->videoRepository->delete($id);
    }
    function find($id){
        return $this->videoRepository->findById($id);
    }
    function update(array $input, $id){
        return $this->videoRepository->update($input, $id);
    }
    function index(){
        return $this->videoRepository->index();
    }
    function getVideoList(){
        return $this->videoRepository->getVideoList();
    }
}
