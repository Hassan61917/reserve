<?php

use App\Http\Middleware\BanMiddleware;
use App\Http\Middleware\BeforeMiddleware;
use App\Http\Middleware\HandleTwoWordsModelBinding;
use App\Http\Middleware\HasRole;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api([
            HandleTwoWordsModelBinding::class,
            BeforeMiddleware::class,
        ]);
        $middleware->alias([
            "role" => HasRole::class,
            "notBan" => BanMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
