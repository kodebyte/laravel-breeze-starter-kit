<?php

namespace App\Observers;

use App\Models\Employee;
use App\Notifications\SystemNotification;

class EmployeeObserver
{
    public function updated(Employee $employee): void
    {
        // 1. Deteksi Perubahan Role
        if ($employee->wasChanged('role_id') || $employee->roles()->exists()) {
            // Kirim notif ke user yang bersangkutan
            $employee->notify(new SystemNotification(
                title: 'Security Alert: Role Changed',
                message: 'Akses akun lo baru saja diperbarui oleh sistem.',
                type: 'warning',
                url: route('admin.profile.edit')
            ));
        }
    }

    public function deleted(Employee $employee): void
    {
        // 2. Notif ke Super Admin kalau ada staff dihapus
        // Misal lo punya logic buat cari Super Admin
        $admins = Employee::role('admin')->get();
        
        foreach ($admins as $admin) {
            $admin->notify(new SystemNotification(
                title: 'System Update: Staff Removed',
                message: "Akun staff {$employee->name} telah dihapus dari sistem.",
                type: 'danger'
            ));
        }
    }
}
