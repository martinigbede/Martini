<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function ($middleware) {
        // Enregistrer les alias pour Spatie Permission
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->withProviders([
        /*
         * Application Service Providers...
         */
        \Spatie\Permission\PermissionServiceProvider::class,
        App\Providers\AppServiceProvider::class,
        App\Providers\FortifyServiceProvider::class,
        App\Providers\JetstreamServiceProvider::class,
        App\Providers\EventServiceProvider::class,
    ])

    ->create();

    // AJOUTEZ CES LIGNES APRÈS LA CRÉATION DE L'APPLICATION
    \Livewire\Livewire::setScriptRoute(function ($handle) {
        return \Illuminate\Support\Facades\Route::get('/livewire/livewire.js', $handle);
    });

    \Livewire\Livewire::setUpdateRoute(function ($handle) {
        return \Illuminate\Support\Facades\Route::post('/livewire/update', $handle)
            ->middleware(['web']);
    });
    
