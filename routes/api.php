<?php

use App\Http\Controllers\api\v1\ArticleController;
use App\Http\Controllers\api\v1\TypeArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/

Route::prefix('articles')->controller(ArticleController::class)->group(function () {
    Route::get('news', 'getNews');
});
Route::apiResources([
    "articles"=>ArticleController::class,
    "typearticles"=>TypeArticleController::class,
    /*"pays"=>PaysController::class,
    "pubs"=>PubController::class,
    "pubdimensions"=>PubDimensionController::class,
    "rubriques"=>RubriqueController::class,
    "sousrubriques"=>SousRubriqueController::class,
    "stats"=>StatsController::class,
    "typepubs"=>TypePubController::class,
    "users"=>UserController::class,
    "videos"=>VideoController::class,*/
]);
