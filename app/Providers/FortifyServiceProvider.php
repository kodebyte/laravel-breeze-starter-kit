<?php

namespace App\Providers;

use App\Http\Responses\TwoFactorEnabledResponse;
use App\Http\Responses\TwoFactorDisabledResponse;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationEnabledResponse;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationDisabledResponse;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

// Tambahkan Import Ini untuk Redirect Custom
use App\Http\Responses\LoginResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Contracts\TwoFactorLoginResponse as TwoFactorLoginResponseContract;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // 1. Matikan Route Bawaan Fortify (Karena kita pakai prefix admin manual)
        Fortify::ignoreRoutes();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 2. Custom Redirect (Biar abis login lari ke Dashboard Admin)
        $this->app->singleton(LoginResponseContract::class, LoginResponse::class);
        $this->app->singleton(TwoFactorLoginResponseContract::class, LoginResponse::class);

        // A. View Login
        Fortify::loginView(function () {
            return view('admin.auth.login'); 
        });

        // B. View Challenge 2FA (Input Kode OTP)
        Fortify::twoFactorChallengeView(function () {
            return view('admin.auth.two-factor-challenge');
        });

        // C. View Confirm Password (SOLUSI ERROR LO) ✅
        Fortify::confirmPasswordView(function () {
            return view('admin.auth.confirm-password');
        });

        // 4. Rate Limiter (Standar Fortify)
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;
            return Limit::perMinute(10)->by($email . $request->ip());
        });
        
        // Rate Limiter untuk 2FA
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(10)->by($request->session()->get('login.id'));
        });
    }
}