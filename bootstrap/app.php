<?php

use App\Console\Commands\SlugUpdCommand;
use App\Http\Middleware\RewriteAuthHeader;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        apiPrefix: '',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withCommands([
        SlugUpdCommand::class,
    ])
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->prepend(RewriteAuthHeader::class);
        $middleware->preventRequestForgery(except: [
            'laravel-filemanager/*',
            'filemanager/*',
        ]);

    })

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
