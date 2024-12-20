<?php

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
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'authorizeRole' => \App\Http\Middleware\AuthorizeRoleMiddleware::class,
            'isMyPlanning' => \App\Http\Middleware\IsMyPlanningMiddleware::class,
            'isNotMyPlanning' => \App\Http\Middleware\isNotMyPlanningMiddleware::class,
            'isSubscrited' => \App\Http\Middleware\IsSubscritedMiddleware::class,
            'validatePayment' => \App\Http\Middleware\ValidatePayment::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
