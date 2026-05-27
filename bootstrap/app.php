<?php

use App\Http\Middleware\IsAdminMiddleware;
use App\Http\Middleware\IsInstructorMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            'stripe/*',
        ]);
        $middleware->append(IsAdminMiddleware::class);
        $middleware->append(IsInstructorMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withEvents(discover: [
        __DIR__.'/../app/Listeners',
    ])
    ->create();

$publicPath = file_exists(dirname(__DIR__).'/../htdocs')
    ? dirname(__DIR__).'/../htdocs'
    : dirname(__DIR__).'/public';

$app->usePublicPath($publicPath);

return $app;
