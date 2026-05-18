<?php

namespace App\Repositories;

use App\Helpers\Helper;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\PaysResource;
use App\Http\Resources\TypeArticleResource;
use App\IRepositories\IArticleRepository;
use App\Models\Article;
use App\Models\Pays;
use App\Models\Typearticle;
use Carbon\Carbon;
use Html2Text\Html2Text;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
        return new ArticleResource(parent::findById($id)) ;
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
        return  ArticleResource::collection(
            parent::index()
                ->sortByDesc('datearticle')
                ->take(100)
                ->values()

        ) ;
    }

    function getNews()
    {

        $cacheKey = 'news_articles';
        //Cache::forget($cacheKey) ;
        $cacheExpiry = now()->addMinutes(10);
        return  Cache::remember($cacheKey , $cacheExpiry, function () {
            $articles= Article::News()
                ->with(['countries','typenews'])
                ->orderByDesc('datearticle')
                ->limit(60)
                ->get();
            //return ArticleResource::collection($articles);
            return ArticleResource::collection($articles)->toArray(request());
        });
        //dd($articles);
        //return $articlesData;
    }

    function getBySlug($slug)
    {
        $article=Article::with(['countries','typenews'])
            ->where('slug',$slug)
            ->firstOrFail();
            $article->increment('hit');

        return new ArticleResource($article);
    }

    function getTypeArticle()
    {
        return TypeArticleResource::collection(Typearticle::all()->sortBy('typearticle'));
    }

    function getCountries()
    {
        return PaysResource::collection(Pays::all()->sortBy('pays'));
    }

    function search($request)
    {
        $articles=Article::query()
            ->with(['countries','typenews'])
            ->Search($request)
            ->orderByDesc('datearticle')
            ->limit(500)
            ->get();
        return $articles ? ArticleResource::collection($articles) : null;
    }
    function getCommunaute(){
        $cacheKey = 'news_communautes';
        //Cache::forget($cacheKey) ;
        $cacheExpiry = now()->addMonth();
        $communautes= Cache::remember($cacheKey , $cacheExpiry, function () {
            $articles= Article::Banen()
                ->with(['countries','typenews'])
                ->orderByDesc('datearticle')
                ->limit(3)
                ->get();
            return ArticleResource::collection($articles)->resolve();
        });
        //dd($articles);
        return $communautes;
    }
}
