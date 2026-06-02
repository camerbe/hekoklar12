<?php

use App\Http\Controllers\AmpController;
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


Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
