<?php

use App\Http\Controllers\api\v1\ArticleController;
use App\Http\Controllers\api\v1\BinomeController;
use App\Http\Controllers\api\v1\MembreController;
use App\Http\Controllers\api\v1\MessageController;
use App\Http\Controllers\api\v1\RoleController;
use App\Http\Controllers\api\v1\TypeArticleController;
use App\Http\Controllers\api\v1\TypeMessageController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/
Route::post('/register',[RegisteredUserController::class,'store'])->name('register');
Route::post('/login',[AuthenticatedSessionController::class,'store'])->name('login');
Route::prefix('articles')->controller(ArticleController::class)->group(function () {
    Route::get('news', 'getNews');
});
Route::prefix('messages')->controller(MessageController::class)->group(function () {
    Route::get('ag', 'getCurrentAGMessage');
});
Route::prefix('membres')->controller(MembreController::class)->group(function () {
    Route::get('actif', 'getActiveMember');
});

Route::apiResources([
    "articles"=>ArticleController::class,
    "typearticles"=>TypeArticleController::class,
    "typemessages"=>TypeMessageController::class,
    "messages"=>MessageController::class,
    "roles"=>RoleController::class,
    "membres"=>MembreController::class,
    "binomes"=>BinomeController::class,
    /*"stats"=>StatsController::class,
     "typepubs"=>TypePubController::class,
     "users"=>UserController::class,
     "videos"=>VideoController::class,*/
]);
