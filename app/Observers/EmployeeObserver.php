<?php

namespace App\Observers;

use App\Models\Employee;
use App\Notifications\SystemNotification;

class EmployeeObserver
{
    /**
     * Handle the Employee "updated" event.
     */
    public function updated(Employee $employee): void
    {
        // 1. Deteksi Perubahan Role atau Akses
        if ($employee->wasChanged('role_id') || $employee->roles()->exists()) {
            // Mengubah pesan ke Bahasa Inggris agar lebih profesional
            $employee->notify(new SystemNotification(
                title: 'Security Alert: Role Updated',
                message: 'Your account access has been recently updated by the system.',
                type: 'warning',
                url: route('admin.profile.edit')
            ));
        }
    }

    /**
     * Handle the Employee "deleted" event.
     */
    public function deleted(Employee $employee): void
    {
        // 2. Notif ke Admin kalau ada staff yang dihapus
        $admins = Employee::role('admin')->get();
        
        foreach ($admins as $admin) {
            $admin->notify(new SystemNotification(
                title: 'System Update: Staff Removed',
                message: "Staff account for {$employee->name} has been successfully removed from the system.",
                type: 'danger'
            ));
        }
    }
}