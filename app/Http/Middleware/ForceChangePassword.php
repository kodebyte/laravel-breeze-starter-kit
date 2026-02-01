<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ForceChangePassword
{
    public function handle(Request $request, Closure $next): Response
{
    $user = Auth::guard('employee')->user();

    if ($user) {
        $isAtForcePage = $request->routeIs('admin.force-password-change.*');
        $isLoggingOut = $request->routeIs('admin.logout');

        // Jika WAJIB ganti (1) tapi lagi kelayapan di menu lain -> Tarik ke halaman ganti password
        if ($user->must_change_password && !$isAtForcePage && !$isLoggingOut) {
            return to_route('admin.force-password-change.index')
                ->with('warning', 'Security notice: Please update your default password.');
        }

        // Jika SUDAH ganti (0) tapi iseng mau masuk halaman ganti password paksa -> Tendang ke Dashboard
        if (!$user->must_change_password && $isAtForcePage) {
            return to_route('admin.dashboard');
        }
    }

    return $next($request);
}
}
