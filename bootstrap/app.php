<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->prefix('internal') // Prefix URL: domain.com/internal/...
                ->name('admin.')     // Prefix Name: route('admin.dashboard')
                ->group(base_path('routes/admin.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
        
        // 1. LOGIC KALAU UDAH LOGIN (Pengganti RedirectIfAuthenticated)
        // Kalau staff udah login tapi buka '/internal', lempar ke dashboard
        $middleware->redirectUsersTo(function (Request $request) {
            // Cek apakah yang login adalah Employee?
            if (Auth::guard('employee')->check()) {
                return route('admin.dashboard');
            }
            
            // Default User biasa
            return '/dashboard';
        });

        // 2. LOGIC KALAU BELUM LOGIN (Pengganti Authenticate Middleware)
        // Kalau tamu buka '/internal/dashboard', arahkan ke login admin yang bener
        $middleware->redirectGuestsTo(function (Request $request) {
            if ($request->is('internal*')) {
                return route('admin.login');
            }
            
            // Default User biasa
            return route('login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
