<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EmployeeStatus;
use App\Http\Controllers\Controller;
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
        // 1. Statistik Utama
        $stats = [
            'total_employees' => Employee::count(),
            'active_employees' => Employee::where('status', EmployeeStatus::ACTIVE)->count(),
            'locked_accounts' => Employee::where('failed_login_attempts', '>=', 5)->count(), // Yg kena auto-lock
            'system_status' => Setting::get('maintenance_mode') ? 'Maintenance' : 'Live',
        ];

        // 2. Data Terbaru (Recent Employees)
        $recentEmployees = Employee::with('roles')
                            ->latest()
                            ->take(5)
                            ->get();

        return view('admin.dashboard', compact('stats', 'recentEmployees'));
    }
}