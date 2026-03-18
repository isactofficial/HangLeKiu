<?php

use App\Http\Middleware\JwtMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',     // ← tambahkan ini
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role'     => \App\Http\Middleware\RoleMiddleware::class, // ← tetap ada
            'jwt.auth' => JwtMiddleware::class,                       // ← tambahkan ini
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();