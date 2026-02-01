<?php

namespace App\Providers;

use App\Enums\EmployeeStatus;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Authenticated;
use App\Models\Employee;
use App\Notifications\SystemNotification;
use App\Observers\EmployeeObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Employee::observe(EmployeeObserver::class);

        /**
         * 1. Listener: Failed Login Attempt (Lockout Logic)
         * Mencatat kegagalan login dan mengunci akun jika mencapai batas.
         */
        Event::listen(Failed::class, function ($event) {
            if ($event->guard === 'employee') {
                $email = $event->credentials['email'] ?? 'Unknown';
                $ipAddress = request()->ip();

                $employee = Employee::where('email', $email)->first();

                if ($employee) {
                    // Tambah hitungan gagal di database
                    $employee->increment('failed_login_attempts');

                    // Jika sudah 5 kali gagal, kunci akun secara otomatis
                    if ($employee->failed_login_attempts >= 5) {
                        $employee->update([
                            'status' => EmployeeStatus::INACTIVE,
                            'locked_at' => now(),
                        ]);

                        $this->sendAdminSecurityNotification(
                            title: 'Security Alert: Account Locked',
                            message: "The account {$email} has been automatically locked due to 5 consecutive failed login attempts from IP: {$ipAddress}"
                        );
                    } else {
                        // Notifikasi percobaan gagal biasa (Existing logic)
                        $this->sendAdminSecurityNotification(
                            title: 'Security Alert: Failed Login Attempt',
                            message: "A failed login attempt was detected for account: {$email} from IP: {$ipAddress}"
                        );
                    }
                }
            }
        });

        /**
         * 2. Listener: Successful Login (Reset Logic)
         * Mengembalikan counter ke 0 jika user berhasil login.
         */
        Event::listen(Authenticated::class, function ($event) {
            if ($event->guard === 'employee') {
                if ($event->user instanceof Employee) {
                    $event->user->update([
                        'failed_login_attempts' => 0,
                        'locked_at' => null,
                    ]);
                }
            }
        });
    }

    /**
     * Helper: Kirim notifikasi keamanan ke semua Admin Kodebyte
     */
    private function sendAdminSecurityNotification(string $title, string $message): void
    {
        $admins = Employee::whereHas('roles', function($q) {
            $q->where('name', 'admin')->where('guard_name', 'employee');
        })->get();

        foreach ($admins as $admin) {
            if ($admin instanceof Employee) {
                $admin->notify(new SystemNotification(
                    title: $title,
                    message: $message,
                    type: 'danger'
                ));
            }
        }
    }
}
