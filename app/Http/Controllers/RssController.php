<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Services\ArticleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class RssController extends Controller
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
    public function feed(){
        $items=ArticleResource::collection(
            array_slice($this->articleService->getNews(), 0, 20)
        );
        $rss = View::make('rss.feed', compact('items'));
        return response($rss, 200)->header('Content-Type', 'application/xml');

    }
    public function communaute(){
        $items=ArticleResource::collection($this->articleService->getCommunaute());
        $rss = View::make('rss.communaute', compact('items'));
        return response($rss, 200)->header('Content-Type', 'application/xml');
    }
    public function culture(){
        $items=ArticleResource::collection($this->articleService->getCultureBanen());
        $rss = View::make('rss.culture', compact('items'));
        return response($rss, 200)->header('Content-Type', 'application/xml');
    }

}
