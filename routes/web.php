<?php

use App\Http\Controllers\AmpController;
use App\Http\Controllers\RssController;
use App\Http\Controllers\SitemapArticleController;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
/*
Route::get('/', function () {
    return view('welcome');
});*/

Route::prefix('amp')->controller(AmpController::class)->group(function () {
    Route::get('accueil', 'index')->name('amp.index');
    Route::get('{article}/{slug}', 'index1')->name('amp.index1');
});

Route::prefix('rss')->controller(RssController::class)->group(function () {
    Route::get('', 'feed')->name('rss.main');
    Route::get('communaute',  'communaute')->name('rss.communaute');
    Route::get('culture', 'culture')->name('rss.culture');

});
Route::get('/sitemapindex.xml', [SitemapArticleController::class, 'index'])->name('sitemap.index');


/*Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});*/
