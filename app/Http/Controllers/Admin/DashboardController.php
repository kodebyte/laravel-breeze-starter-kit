<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EmployeeStatus;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Employee;
use App\Models\Setting;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\View\View;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class DashboardController extends Controller implements HasMiddleware
{
    /**
     * Define Middleware (Laravel 12 Style)
     */
    public static function middleware(): array
    {
        return [
            // Pastikan user minimal punya akses view dashboard
            new Middleware('permission:dashboard.view'),
        ];
    }

    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'totalUsers'     => User::count(),
            'totalEmployees' => Employee::count(),
            'totalRoles'     => Role::count(),
            'todayLogs'      => ActivityLog::whereDate('created_at', now())->count(),
            'recentLogs'     => ActivityLog::latest()->take(5)->get(),
        ]);
    }
}