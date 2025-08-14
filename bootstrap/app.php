<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then:function(){
            Route::middleware('web')->prefix('control-panel')->name('admin.')->group(base_path('routes/admin.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin.guest'=>\App\Http\Middleware\RedirectIfAuthenticated::class,
            'isAdmin'=> \App\Http\Middleware\IsAdmin::class,
            '2Factor'=> \App\Http\Middleware\Admin\CheckTwoFactor::class,
            'checkVisitor'=> \App\Http\Middleware\CheckVisitor::class,
            'checkCompanyUpdate'=> \App\Http\Middleware\checkCompanyUpdate::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
