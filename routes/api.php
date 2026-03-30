<?php

use App\Http\Controllers\api\v1\ArticleController;
use App\Http\Controllers\api\v1\MessageController;
use App\Http\Controllers\api\v1\RoleController;
use App\Http\Controllers\api\v1\TypeArticleController;
use App\Http\Controllers\api\v1\TypeMessageController;
use Illuminate\Support\Facades\Route;

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/

Route::prefix('articles')->controller(ArticleController::class)->group(function () {
    Route::get('news', 'getNews');
});
Route::prefix('messages')->controller(MessageController::class)->group(function () {
    Route::get('ag', 'getCurrentAGMessage');
});
Route::apiResources([
    "articles"=>ArticleController::class,
    "typearticles"=>TypeArticleController::class,
    "typemessages"=>TypeMessageController::class,
    "messages"=>MessageController::class,
    "roles"=>RoleController::class,
    /*"rubriques"=>RubriqueController::class,
    "sousrubriques"=>SousRubriqueController::class,
    "stats"=>StatsController::class,
    "typepubs"=>TypePubController::class,
    "users"=>UserController::class,
    "videos"=>VideoController::class,*/
]);
