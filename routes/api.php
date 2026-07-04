<?php

use App\Http\Controllers\api\v1\ArticleController;
use App\Http\Controllers\api\v1\BinomeController;
use App\Http\Controllers\api\v1\MembreController;
use App\Http\Controllers\api\v1\MessageController;
use App\Http\Controllers\api\v1\RoleController;
use App\Http\Controllers\api\v1\TypeArticleController;
use App\Http\Controllers\api\v1\TypeMessageController;
use App\Http\Controllers\api\v1\UserController;
use App\Http\Controllers\api\v1\VerifyEmailController;
use App\Http\Controllers\api\v1\VideoController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
//use Laravel\Fortify\Http\Controllers\VerifyEmailController;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/

Route::post('/login',[AuthenticatedSessionController::class,'store'])->name('login');
Route::post('/forgot-password',[PasswordResetLinkController::class,'store'])->name('forgot-password');
Route::post('/reset-password',[NewPasswordController::class,'store'])->name('reset-password');
Route::get('/sanctum/csrf-cookie',[CsrfCookieController::class,'show'])->name('sanctum.csrf-cookie');


Route::prefix('articles')->controller(ArticleController::class)->group(function () {
    Route::get('news', 'getNews');
    route::get('slug/{slug}','getBySlug');
    //route::get('banen','getCommunaute');
    route::get('mostreaded','getMostReaded');
    //route::get('culture/banen','getCultureBanen');
    route::get('banen','getAllBanen');

});
Route::prefix('messages')->controller(MessageController::class)->group(function () {
    Route::get('ag', 'getCurrentAGMessage');
});
Route::prefix('membres')->controller(MembreController::class)->group(function () {
    Route::get('actif', 'getActiveMember');
    Route::get('stat', 'getStat');
});
Route::prefix('binomes')->controller(BinomeController::class)->group(function () {
    Route::get('mois', 'getMonthBinome');
});
Route::prefix('videos')->controller(VideoController::class)->group(function () {
    Route::get('one', 'getRandomVideo');
    Route::get('list', 'getVideoList');

});
Route::prefix('users')->controller(UserController::class)->group(function () {
    Route::get('team', 'getTeam');
});
Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    //->middleware(['signed', 'resolve.verifiable.user'])
    ->name('verification.verify');
/*Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    //return redirect('/home');
})->middleware(['signed', 'resolve.verifiable.user'])->name('verification.verify');*/

Route::group(['middleware' => 'auth:sanctum'], function (){

    Route::apiResources([
        "articles"=>ArticleController::class,
        "typearticles"=>TypeArticleController::class,
        "typemessages"=>TypeMessageController::class,
        "messages"=>MessageController::class,
        "roles"=>RoleController::class,
        "membres"=>MembreController::class,
        "binomes"=>BinomeController::class,
        "users"=>UserController::class,
        "videos"=>VideoController::class,
        /*"stats"=>StatsController::class,
         "typepubs"=>TypePubController::class,

         */
    ]);
    Route::post('/logout',[AuthenticatedSessionController::class,'destroy'])->name('logout');
    Route::post('/register',[RegisteredUserController::class,'store'])->name('register');
    Route::get('/messagetype',[MessageController::class,'getTypeMessages'])->name('messagetype');
    //Route::get('/email/verify/{id}/{hash}',[VerifyEmailController::class,'__invoke'])->name('verification.verify');

    Route::prefix('articles')->controller(ArticleController::class)->group(function () {
        route::get('/type/articles','getTypeArticle');
        route::get('pays/countries','getCountries');
        route::get('search/{search}','search');

    });

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'Lien renvoyé'
        ]);
    })->middleware(['throttle:6,1']);



});


