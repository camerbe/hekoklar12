<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Resources\ArticleResource;
use App\Services\ArticleService;
use App\Services\MembreService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class AmpController extends Controller
{
    //
    protected $articleService;
    protected $membreService;
    /**
     * @param $articleService
     * @param $membreService
     */
    public function __construct(ArticleService  $articleService,MembreService $membreService)
    {
        $this->articleService = $articleService;
        $this->membreService = $membreService;
    }
    public function index(Request $request){
        $perPage = 10;
        $currentPage = (int) $request->input('page', 1);

        Cache::forget('articles_json');
        $articles = Cache::remember('articles_json', now()->addHours(12), function () {
            return collect($this->articleService->getNews());// API call


        });
        //return collect( $articles);
        $currentItems = $articles
            ->slice(($currentPage - 1) * $perPage, $perPage)
            ->values();
        //dd($currentItems);
        $paginated = new LengthAwarePaginator(
            $currentItems,
            $articles->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // ✅ JSON-LD propre
        $listElements = $currentItems->map(function ($article, $index) {

            $today = now()->format('Y-m-d\TH:i:s+00:00');
            $articleDate = \Carbon\Carbon::parse($article['datearticle'])->format('Y-m-d\TH:i:s+00:00');
            $articleUrl = url("amp/" . $article['slug']);

            return [
                "@type" => "ListItem",
                "position" => $index + 1,
                "item" => [
                    "@type" => "NewsArticle",
                    "mainEntityOfPage" => [
                        "@type" => "WebPage",
                        "@id" => $articleUrl
                    ],
                    "headline" => $article['titre'] ?? '',
                    "description" => $article['chapeau'] ?? '',
                    "articleSection" => data_get($article, 'typearticles.typearticle', ''),
                    "keywords" => !empty($article['keyword'])
                        ? array_map('trim', explode(',', $article['keyword']))
                        : [],
                    "inLanguage" => "fr-FR",
                    "url" => $articleUrl,
                    "datePublished" => $articleDate,
                    "dateModified" => $today,
                    "author" => [
                        "@type" => "Person",
                        "name" => $article['auteur'] ?? ''
                    ],
                    "publisher" => [
                        "@type" => "Organization",
                        "name" => "Hekok.org",
                    ],
                    "image" => [
                        "@type" => "ImageObject",
                        "url" => $article['image'] ?? '',
                    ],
                ]
            ];
        });

        $jsonLd = [
            "@context" => "https://schema.org",
            "@type" => "ItemList",
            "itemListElement" => $listElements
        ];

        return view('index', [
            'articles' => $paginated,
            'listElements' => $listElements,
            'jsonLd' => $jsonLd
        ]);
    }

    public function index1(Request $request){
        $slug = $request->route('slug');

        $data=$this->articleService->getBySlug($slug);
        $data=new ArticleResource($data);

        $imageUrl=Helper::extractImgSrc($data['image']);
        //dd($data);
        $typeArticle=(strtolower($data['typenews']['typearticle'])=='article')? 'article' : 'communaute';
        $articleUrl = url("amp/".$typeArticle."/" . $data['slug']);
        $today = now()->format('Y-m-d\TH:i:s+00:00');
        $year = Carbon::parse($data['datearticle'])->year;
        $articleDate = Carbon::parse($data['datearticle'])->format('Y-m-d\TH:i:s+00:00');
        $description =$data['chapeau'];
        $jsonLdArticle= [
            "@context" => "https://schema.org",
            "@type" => "NewsArticle",
            "headline" => $data['titre'],
            "description" => $description,
            "articleSection" => $typeArticle,
            "keywords" => array_map('trim', explode(',', $data['keyword'])),
            "inLanguage" => "fr-FR",
            "url" => url()->current(),
            "datePublished" => $articleDate,
            "dateModified" => $today,
            "isAccessibleForFree" => "True",
            "copyrightYear" => $year,

            "author" => [
                "@type" => "Person",
                "name" => $data['auteur']
            ],
            "editor" => [
                "@type" => "Person",
                "name" => $data['source']
            ],

            "publisher" => [
                "@type" => "Organization",
                "name" => "Camer.be",
                "url" => "https://www.hekok.org",
                "logo" => [
                    "@type" => "ImageObject",
                    "url" => url('assets/img/camer-logo.png'),
                    "width" => 190,
                    "height" => 52
                ]
            ],

            "image" => [
                "@type" => "ImageObject",
                "url" => $imageUrl,
                "width" => 850,
                "height" => 600,
                "caption" => "{$data['countries']['pays']} :: {$data['titre']} - hekok.org"
            ],

            "contentLocation" => [
                "@type" => "Place",
                "name" => $data['countries']['pays']
            ],

            "articleBody" => $data['article'],

            "interactionStatistic" => [
                [
                    "@type" => "InteractionCounter",
                    "interactionType" => [
                        "@type" => "http://schema.org/ReadAction"
                    ],
                    "userInteractionCount" => $data['hit']
                ]
            ],

            "sameAs" => [
                "https://www.facebook.com/camergroup",
                "https://x.com/camerbe"
            ]
        ];
        return view('index1', [
            'article' => $data,
            'jsonLdArticle' => $jsonLdArticle,
            //'jsonLd' => $jsonLd
        ]);
    }

}
