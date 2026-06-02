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
    function getBySlug($slug){
        return $this->articleRepository->getBySlug($slug);
    }
    function getTypeArticle(){
        return $this->articleRepository->getTypeArticle();
    }
    function getCountries(){
        return $this->articleRepository->getCountries();
    }
    function search($search){
        return $this->articleRepository->search($search);
    }
    function getCommunaute(){
        return $this->articleRepository->getCommunaute();
    }

    function getCultureBanen(){
        return $this->articleRepository->getCultureBanen();
    }
    function getMostReaded(){
        return $this->articleRepository->getMostReaded();
    }

    function getAllBanen(){
        return $this->articleRepository->getAllBanen();
    }
}
