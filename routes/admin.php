<?php

use App\Http\Controllers\Admin as Admin;

// --- GUEST ROUTES (Belum Login) ---
Route::middleware('guest:employee')->group(function () {
    
    // UBAH DISINI: Ganti 'login' jadi '/'
    // Pas akses /internal/ dia langsung render halaman login
    Route::get('/', [Admin\Auth\AuthenticatedSessionController::class, 'create'])
        ->name('login');

    // Action POST login-nya kita samain aja ke '/' biar rapi, atau tetap 'login' bebas.
    // Disini gue set ke 'login' biar URL actionnya tetep jelas (POST /internal/login)
    Route::post('login', [Admin\Auth\AuthenticatedSessionController::class, 'store'])
        ->name('login.store');
});

Route::middleware(['auth:employee', 'force.change.password'])->group(function () {
    Route::get('/force-password-change', [Admin\ProfileController::class, 'forceChangeIndex'])->name('force-password-change.index');
    Route::post('/force-password-change', [Admin\ProfileController::class, 'forceChangeUpdate'])->name('force-password-change.update');
});

// --- AUTHENTICATED ROUTES (Sudah Login) ---
Route::middleware(['auth:employee', 'force.change.password'])->group(function () {
    Route::get('/dashboard', Admin\DashboardController::class)
        ->name('dashboard');

    Route::post('/logout', [Admin\Auth\AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::get('/logs', [Admin\ActivityLogController::class, 'index'])->name('logs.index');
    Route::get('/logs/{id}', [Admin\ActivityLogController::class, 'show'])->name('logs.show');

    // pages
    Route::post('pages/sync', [Admin\PageController::class, 'sync'])
        ->name('pages.sync');

    // media
    Route::get('/media/', [Admin\MediaController::class, 'index'])->name('media.index');
    Route::post('/media/', [Admin\MediaController::class, 'store'])->name('media.store');
    Route::delete('/media/{id}', [Admin\MediaController::class, 'destroy'])->name('media.destroy');

    // NOTIFICATIONS
    Route::get('/notifications', [Admin\NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{id}/read', [Admin\NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::post('/notifications/mark-all-as-read', [Admin\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{id}', [Admin\NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('/notifications/delete-all', [Admin\NotificationController::class, 'deleteAll'])->name('notifications.deleteAll');

    // Profile Routes
    Route::get('/profile', [Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [Admin\ProfileController::class, 'update'])->name('profile.update');

    Route::get('/settings', [Admin\SettingController::class, 'index'])->name('settings.index');
    Route::patch('/settings', [Admin\SettingController::class, 'update'])->name('settings.update');

    // unlock employee
    Route::patch('/employees/{employee}/unlock', [Admin\EmployeeController::class, 'unlock'])->name('employees.unlock');
    
    // system
    Route::get('system', [App\Http\Controllers\Admin\SystemController::class, 'index'])->name('system.index')
        ->middleware('can:system.view_logs');

    // restore delete
    Route::post('users/{id}/restore', [Admin\UserController::class, 'restore'])->name('users.restore');
    Route::post('employees/{id}/restore', [Admin\EmployeeController::class, 'restore'])->name('employees.restore');

    Route::get('/backups', [Admin\BackupController::class, 'index'])->name('backups.index');
    Route::post('/backups/create', [Admin\BackupController::class, 'create'])->name('backups.create');
    Route::get('/backups/download/{file_name}', [Admin\BackupController::class, 'download'])->name('backups.download');
    Route::delete('/backups/delete/{file_name}', [Admin\BackupController::class, 'destroy'])->name('backups.destroy');

    Route::resource('pages', Admin\PageController::class)
        ->only(['index', 'edit', 'update']);

    Route::resources([
        'users' => Admin\UserController::class,
        'employees' => Admin\EmployeeController::class,
        'roles' => Admin\RoleController::class,
    ]);
});