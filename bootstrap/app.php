<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app->middleware([
    \App\Http\Middleware\TrustProxies::class,
]);

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'preregister.notice' => \App\Http\Middleware\EnsurePregistrationNotice::class,
        ]);
    })
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'one-time-user' => \App\Http\Middleware\EnsureUserEdit::class,
        ]);
    })
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'availability-change' => \App\Http\Middleware\AvailabilityChange::class,
        ]);
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\SanitizeInput::class,
        ]);
    })
    ->withMiddleware(function (Middleware $middleware): void {
    $middleware->throttleWithRedis();
    // ...
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
