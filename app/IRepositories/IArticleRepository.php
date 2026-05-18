<?php

namespace App\IRepositories;

interface IArticleRepository
{
    function getNews();
    function getBySlug($slug);
    function getTypeArticle();
    function getCountries();
    function search($request);

}
