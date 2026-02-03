<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin as Admin;

// --- IMPORT FORTIFY CONTROLLERS ---
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController;
use Laravel\Fortify\Http\Controllers\ConfirmedTwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;

// --- IMPORT CUSTOM CONTROLLER KITA (PENTING) ---
use App\Http\Controllers\Admin\Auth\TwoFactorController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| Prefix URL: /internal (sesuai bootstrap/app.php)
*/

// =========================================================================
// 1. GUEST ROUTES (Belum Login)
// =========================================================================
Route::middleware('guest:employee')->group(function () {
    
    Route::get('/', [Admin\Auth\AuthenticatedSessionController::class, 'create'])
        ->name('admin.login');

    Route::post('login', [Admin\Auth\AuthenticatedSessionController::class, 'store'])
        ->name('admin.login.store');

    // Route ini WAJIB namanya 'two-factor.login' (Murni tanpa prefix admin.)
    // Ini dipakai Fortify saat login admin butuh 2FA
    Route::get('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'create'])
        ->name('two-factor.login');
        
    Route::post('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store']);
});


// =========================================================================
// 2. AUTHENTICATED ROUTES (Sudah Login)
// =========================================================================
Route::middleware(['auth:employee', 'force.change.password'])->group(function () {

    // --- GROUP DENGAN PENAMAAN 'admin.' ---
    Route::name('admin.')->group(function () {
        
        // --- Dashboard & Auth ---
        Route::get('/dashboard', Admin\DashboardController::class)->name('dashboard');
        Route::post('/logout', [Admin\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');

        // --- PASSWORD CONFIRMATION ROUTE ---
        // Namanya jadi: 'admin.password.confirm'
        Route::get('/confirm-password', [Admin\Auth\ConfirmPasswordController::class, 'show'])
            ->name('password.confirm');
            
        Route::post('/confirm-password', [Admin\Auth\ConfirmPasswordController::class, 'store']);


        // ===============================================================
        // 🔥 2FA SETTINGS (AREA SENSITIF) 🔥
        // ===============================================================
        // Middleware 'password.confirm' kita kasih argumen ':admin.password.confirm'
        // Biar dia tau harus redirect kemana kalau session habis (Gak nyasar ke user).
        
        Route::middleware(['password.confirm:admin.password.confirm'])->group(function () {
            
            // Enable & Disable (PAKAI CUSTOM CONTROLLER)
            // Biar redirectnya balik ke Profile, bukan ke Home
            Route::post('/two-factor-authentication', [TwoFactorController::class, 'store'])
                ->name('two-factor.enable');
                
            Route::delete('/two-factor-authentication', [TwoFactorController::class, 'destroy'])
                ->name('two-factor.disable');

            // Sisanya Pakai Controller Bawaan Fortify
            Route::post('/two-factor-authentication-confirmed', [ConfirmedTwoFactorAuthenticationController::class, 'store'])
                ->name('two-factor.confirmed');

            Route::get('/two-factor-qr-code', [TwoFactorQrCodeController::class, 'show'])
                ->name('two-factor.qr-code');

            Route::post('/two-factor-recovery-codes', [RecoveryCodeController::class, 'store'])
                ->name('two-factor.recovery-codes');
        });


        // ===============================================================
        // 🏢 FITUR ADMIN LAINNYA
        // ===============================================================

        // --- Profile & Settings ---
        Route::get('/profile', [Admin\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [Admin\ProfileController::class, 'update'])->name('profile.update');
        
        Route::get('/settings', [Admin\SettingController::class, 'index'])->name('settings.index');
        Route::patch('/settings', [Admin\SettingController::class, 'update'])->name('settings.update');

        // --- Logs & System ---
        Route::get('/logs', [Admin\ActivityLogController::class, 'index'])->name('logs.index');
        Route::get('/logs/{id}', [Admin\ActivityLogController::class, 'show'])->name('logs.show');
        
        Route::get('system', [App\Http\Controllers\Admin\SystemController::class, 'index'])
            ->name('system.index')
            ->middleware('can:system.view_logs');
            
        Route::get('system-logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])
            ->name('system.logs') // Sesuaikan nama route jika perlu
            ->middleware('can:system.view_logs');

        // --- Media ---
        Route::get('/media/', [Admin\MediaController::class, 'index'])->name('media.index');
        Route::post('/media/', [Admin\MediaController::class, 'store'])->name('media.store');
        Route::delete('/media/{id}', [Admin\MediaController::class, 'destroy'])->name('media.destroy');

        // --- Inquiry & Notification ---
        Route::resource('inquiries', Admin\InquiryController::class)->only(['index', 'show', 'destroy']);
        
        Route::get('/notifications', [Admin\NotificationController::class, 'index'])->name('notifications.index');
        Route::patch('/notifications/{id}/read', [Admin\NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
        Route::post('/notifications/mark-all-as-read', [Admin\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
        Route::delete('/notifications/{id}', [Admin\NotificationController::class, 'destroy'])->name('notifications.destroy');
        Route::delete('/notifications/delete-all', [Admin\NotificationController::class, 'deleteAll'])->name('notifications.deleteAll');

        // --- Employees & Users Restore ---
        Route::patch('/employees/{employee}/unlock', [Admin\EmployeeController::class, 'unlock'])->name('employees.unlock');
        Route::post('users/{id}/restore', [Admin\UserController::class, 'restore'])->name('users.restore');
        Route::post('employees/{id}/restore', [Admin\EmployeeController::class, 'restore'])->name('employees.restore');

        // --- Menus & Pages ---
        Route::post('menus/update-tree', [\App\Http\Controllers\Admin\MenuController::class, 'updateTree'])->name('menus.update-tree');
        Route::post('pages/sync', [Admin\PageController::class, 'sync'])->name('pages.sync');

        // --- Backups ---
        Route::get('/backups', [Admin\BackupController::class, 'index'])->name('backups.index');
        Route::post('/backups/create', [Admin\BackupController::class, 'create'])->name('backups.create');
        Route::get('/backups/download/{file_name}', [Admin\BackupController::class, 'download'])->name('backups.download');
        Route::delete('/backups/delete/{file_name}', [Admin\BackupController::class, 'destroy'])->name('backups.destroy');

        // --- Resources (CRUD) ---
        Route::resource('menus', \App\Http\Controllers\Admin\MenuController::class)
            ->only(['index', 'store', 'update', 'destroy']);
            
        Route::resource('pages', Admin\PageController::class)
            ->only(['index', 'edit', 'update']);

        Route::resources([
            'users' => Admin\UserController::class,
            'employees' => Admin\EmployeeController::class,
            'roles' => Admin\RoleController::class,
            'categories' => Admin\CategoryController::class,
            'posts' => Admin\PostController::class,
            'banners' => Admin\BannerController::class,
        ]);
    });
    
    // --- Force Password Change (Diluar admin prefix kalau mau, atau didalam terserah layout) ---
    // Sesuai kode awal lo, ini ada route khusus
    Route::get('/force-password-change', [Admin\ProfileController::class, 'forceChangeIndex'])
        ->name('admin.force-password-change.index');
    Route::post('/force-password-change', [Admin\ProfileController::class, 'forceChangeUpdate'])
        ->name('admin.force-password-change.update');
});