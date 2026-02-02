<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\StoreRoleRequest;
use App\Http\Requests\Admin\Role\UpdateRoleRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log; // Wajib ada buat logging
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller implements HasMiddleware
{
    /**
     * Define Middleware di sini (Laravel 12 Standard)
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:roles.view', only: ['index']),
            new Middleware('permission:roles.create', only: ['create', 'store']),
            new Middleware('permission:roles.update', only: ['edit', 'update']),
            new Middleware('permission:roles.delete', only: ['destroy']),
        ];
    }

    public function index(Request $request): View
    {
        // Filter role khusus guard 'employee'
        $roles = Role::where('guard_name', 'employee')
                ->with('permissions')
                ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
                ->paginate($this->getPerPage())
                ->withQueryString();

        return view('admin.roles.index', compact('roles'));
    }

    public function create(): View
    {
        $permissions = Permission::where('guard_name', 'employee')->get();
        
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request): RedirectResponse
    {
        try {
            // 1. Create Role
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'employee' // Hardcode ke employee untuk admin panel
            ]);

            // 2. Sync Permissions
            if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions);
            }

            return to_route('admin.roles.index')
                ->with('success', 'New role created successfully.');

        } catch (\Throwable $e) {
            // Standard Logging
            Log::error('Error creating role: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Failed to create role.');
        }
    }

    public function edit(Role $role): View|RedirectResponse
    {
        if ($role->name === 'Super Admin') {
            return back()->with('error', 'Super Admin role cannot be deleted.');
        }

        $permissions = Permission::where('guard_name', 'employee')->get();
        
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        if ($role->name === 'Super Admin') {
            return back()->with('error', 'Super Admin role cannot be modified.');
        }

        try {
            // 1. Update Name
            $role->update(['name' => $request->name]);
            
            // 2. Sync Permissions
            // Menggunakan syncPermissions akan menghapus yang lama dan insert yang baru
            $role->syncPermissions($request->permissions ?? []);

            return to_route('admin.roles.index')
                ->with('success', 'Role updated successfully.');

        } catch (\Throwable $e) {
            // Standard Logging
            Log::error('Error updating role ID ' . $role->id . ': ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Failed to update role.');
        }
    }

    public function destroy(Role $role): RedirectResponse
    {
        if ($role->name === 'Super Admin') {
            return back()->with('error', 'Super Admin role cannot be deleted.');
        }
        
        try {
            // Guard: Cegah hapus Super Admin
            if ($role->name === 'Super Admin') {
                return back()->with('error', 'Super Admin role cannot be deleted!');
            }

            $role->delete();

            return to_route('admin.roles.index')
                ->with('success', 'Role deleted successfully.');

        } catch (\Throwable $e) {
            // Standard Logging
            Log::error('Error deleting role ID ' . $role->id . ': ' . $e->getMessage());

            return back()->with('error', 'Failed to delete role.');
        }
    }
}