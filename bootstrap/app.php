<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AuthenticateSSO;
use App\Http\Middleware\CheckFaculty;
use App\Http\Middleware\RedirectBySsoRole;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        channels: __DIR__ . '/../routes/channels.php',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth.sso' => AuthenticateSSO::class,
            'check.faculty' => CheckFaculty::class,
            //test
            'redirect.by.sso' => RedirectBySsoRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
