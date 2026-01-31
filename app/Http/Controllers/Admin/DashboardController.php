<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        // Kita ambil data statistik sederhana buat pemanis dashboard
        $stats = [
            'total_employees' => Employee::count(),
            'total_roles'     => Role::count(),
            // Nanti bisa tambah total_users, total_projects, dll disini
        ];

        return view('admin.dashboard', compact('stats'));
    }
}