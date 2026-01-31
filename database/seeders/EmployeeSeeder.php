<?php

namespace Database\Seeders;

use App\Enums\EmployeeStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Role Super Admin
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create roles and assign created permissions
        $role = \App\Models\Role::create(['name' => 'Super Admin', 'guard_name' => 'employee']);

        // 2. Create Employee Account
        $employee = \App\Models\Employee::create([
            'name' => 'Bro Li',
            'email' => 'admin@kodebyte.com',
            'password' => bcrypt('password'),
            'status' => EmployeeStatus::ACTIVE, // Pakai Enum value
        ]);

        // 3. Assign Role
        $employee->assignRole($role);
    }
}
