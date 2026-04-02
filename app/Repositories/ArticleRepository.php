<?php

namespace App\Repositories;

use App\Helpers\Helper;
use App\Http\Resources\ArticleResource;
use App\IRepositories\IArticleRepository;
use App\Models\Article;
use App\Models\Pays;
use Carbon\Carbon;
use Html2Text\Html2Text;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ArticleRepository extends Repository implements IArticleRepository
{


    public function __construct(Article $article)
    {
        parent::__construct($article);
    }

    function create(array $input)
    {
        $bled=Pays::find($input['pays_id']);
        $html=new Html2Text($input['article']);
        $input['chapeau']=Str::of($html->getText())->limit(160);
        $input['datearticle']=Carbon::parse($input['datearticle'])->format('Y-m-d H:i:s');
        $input['slug']=Str::slug(Helper::getTitle($bled->pays,$input['titre']),'-') ;
        $input['auteur']=Str::title($input['auteur']);
        $input['source']=Str::title($input['source']);
        $input['titre']=Helper::guillemets($input['titre']);
        return parent::create($input);
    }

    function delete($id)
    {
        return parent::delete($id);
    }

    function findById($id)
    {
        return parent::findById($id);
    }

    function update(array $input, $id)
    {

        $current=$this->findById($id);
        //dd($current);
        $bled=Pays::find($current->pays_id);

        $input['auteur']=isset($input['auteur']) ? Str::title($input['auteur']):$current->auteur;
        $input['source']=isset($input['source']) ? Str::title($input['source']):$current->auteur;
        $input['datearticle']=isset($input['datearticle']) ? Carbon::parse($input['datearticle'])->format('Y-m-d H:i:s')
            :$current->datearticle;
        if(isset($input['article'])){
            $html=new Html2Text($input['article']);
            $input['chapeau']=Str::of($html->getText())->limit(160);
        }
        if(isset($input['titre']) || isset($input['pays_id'])){
            $input['slug']=Str::slug(Helper::getTitle($bled->pays,$input['titre']),'-') ;
        }
        $input['titre']=Helper::guillemets($input['titre']);
        return parent::update($input, $id);
    }

    function index()
    {
        return  ArticleResource::collection(parent::index()) ;
    }

    function getNews()
    {

        $cacheKey = 'news_articles';
        //Cache::forget($cacheKey) ;
        $cacheExpiry = now()->addDay();
        $articlesData= Cache::remember($cacheKey , now()->addDay(), function () {
            $articles= Article::News()
                ->with(['countries','typenews'])
                ->orderByDesc('datearticle')
                ->limit(50)
                ->get();
            return ArticleResource::collection($articles)->resolve();
        });
        //dd($articles);
        return $articlesData;
    }
}
