<?php

namespace App\Providers;

use App\IRepositories\IArticleRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\Repository;
use App\Repositories\TypeArticleRepository;
use App\Services\ArticleService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->when(ArticleService::class)
             ->needs(IArticleRepository::class)
             ->give(ArticleRepository::class);

        $this->app->bind(Repository::class,TypeArticleRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
