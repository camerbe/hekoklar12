<?php

namespace App\Services;

use App\IRepositories\IArticleRepository;

class ArticleService
{

    public function __construct(protected IArticleRepository $articleRepository)
    {

    }

    function create(array $input)
    {
        return $this->articleRepository->create($input);
    }
    function delete($id){
        return $this->articleRepository->delete($id);
    }
    function find($id){
        return $this->articleRepository->findById($id);
    }
    function update(array $input, $id){
        return $this->articleRepository->update($input, $id);
    }
    function index(){
        return $this->articleRepository->index();
    }

    function getNews()
    {
        return $this->articleRepository->getNews();

     }
}
