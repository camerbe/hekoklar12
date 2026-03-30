<?php

namespace App\Providers;

use App\IRepositories\IArticleRepository;
use App\IRepositories\IMessageRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\MessageRepository;
use App\Repositories\Repository;
use App\Repositories\TypeArticleRepository;
use App\Repositories\TypeMessageRepository;
use App\Services\ArticleService;
use App\Services\MessageService;
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
        $this->app->bind(Repository::class,TypeMessageRepository::class);

        $this->app->when(MessageService::class)
            ->needs(IMessageRepository::class)
            ->give(MessageRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
