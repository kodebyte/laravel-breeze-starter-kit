<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureIsSuperAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user login (Cek guard employee atau web default)
        $user = Auth::guard('employee')->user() ?? Auth::user();

        // 2. Kalau gak login, atau BUKAN Super Admin -> Tendang
        if (! $user || ! $user->hasRole('Super Admin')) {
            abort(403, 'Unauthorized. Only Super Admin can view system logs.');
        }

        return $next($request);
    }
}