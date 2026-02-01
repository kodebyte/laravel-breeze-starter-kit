<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
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
            'total_users'     => User::count(),
            'total_roles'     => Role::where('guard_name', 'employee')->count(),
            'active_staff'    => Employee::where('status', \App\Enums\EmployeeStatus::ACTIVE)->count(),
        ];

        // 2. Data Terbaru (Recent Employees)
        $recentEmployees = Employee::with('roles')
                            ->latest()
                            ->take(5)
                            ->get();

        return view('admin.dashboard', compact('stats', 'recentEmployees'));
    }
}