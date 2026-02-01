<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Reset Cached Roles/Permissions (Wajib!)
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Define Permissions Group
        // Format: [Resource] => [Actions List]
        $permissions = [
            'dashboard' => ['view'],
            
            // Module: User Management (Clients)
            'users' => ['view', 'create', 'update', 'delete'],
            
            // Module: Employee Management (Internal)
            'employees' => ['view', 'create', 'update', 'delete', 'restore'],
            
            // Module: Role & Access (Sensitive)
            'roles' => ['view', 'create', 'update', 'delete'],
        ];

        // 3. Create Permissions Loop
        $guardName = 'employee'; // Guard kita

        foreach ($permissions as $module => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => "{$module}.{$action}", // users.create
                    'guard_name' => $guardName
                ]);
            }
        }

        // 4. Assign Permissions to Roles (Otomatisasi)
        
        // A. Super Admin: Dapet SEMUA permission
        $superAdmin = Role::where('name', 'Super Admin')->where('guard_name', $guardName)->first();
        if ($superAdmin) {
            $superAdmin->givePermissionTo(Permission::all());
        }

        // B. Staff: Dapet permission View doang (Contoh default)
        $staff = Role::where('name', 'Staff')->where('guard_name', $guardName)->first();
        if ($staff) {
            $staff->givePermissionTo([
                'dashboard.view',
                'users.view',
                'employees.view',
                // Staff ga dikasih akses roles.view biar ga kepo
            ]);
        }
    }
}
