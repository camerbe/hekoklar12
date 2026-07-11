<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapArticleController extends Controller
{
    //
    protected $articleService;

    /**
     * @param $articleService
     */
    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index(){
        $articles=$this->articleService->getNews();
        $sitemap=Sitemap::create();
        foreach ($articles as $article){
            $rub=strtolower($article["typearticles"]["typearticle"]);
            $rub=str_replace($rub,'actualites',$rub);
            $image=$article["image"] ?? 'https://picsum.photos/850/600';
            $sitemap->add(
                Url::create(env('FRONTEND_URL')."/{$rub}/{$article['slug']}")
                ->setLastModificationDate(Carbon::parse($article["datearticle"]))
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(0.8)
                ->addImage($image)
            );
        }
        return response($sitemap->render(), 200, ['Content-Type' => 'application/xml']);
    }

}
