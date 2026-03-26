<?php

use App\Http\Controllers\api\v1\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/

Route::prefix('articles')->controller(ArticleController::class)->group(function () {
    Route::get('news', 'getNews');

});
