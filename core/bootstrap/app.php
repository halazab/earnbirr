<?php

use App\Http\Middleware\LocalizationMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'admin.guest' => \App\Http\Middleware\AdminGuestMiddleware::class,
            'check.status' => \App\Http\Middleware\CheckStatusMiddleware::class,
            'kyc' => \App\Http\Middleware\CheckKycMiddleware::class,
            'maintenance' => \App\Http\Middleware\MaintenanceMiddleware::class,
        ])->redirectGuestsTo(fn () => route('user.login'))
            ->appendToGroup('web', LocalizationMiddleware::class)
            ->validateCsrfTokens(except: [
                '/clear',
                '/placeholder-image/*',
                'check-user',
            ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
