<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Setting;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah Maintenance Mode Aktif di Database
        $isMaintenance = Setting::get('maintenance_mode') == '1';

        // 2. Logic Pengecualian:
        // - Kalau TIDAK maintenance, lanjut.
        // - Kalau rute ADMIN, lanjut (biar admin gak kekunci di luar).
        // - Kalau user yang login adalah Admin/Karyawan, lanjut.
        if (!$isMaintenance || $request->is('admin*') || auth()->guard('employee')->check()) {
            return $next($request);
        }

        // 3. Kalau kena blokir, tampilkan 503 Service Unavailable
        abort(503, 'System is under maintenance. Please check back later.');
    }
}