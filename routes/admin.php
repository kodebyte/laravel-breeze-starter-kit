<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin as Admin;

// --- GUEST ROUTES (Belum Login) ---
Route::middleware('guest:employee')->group(function () {
    
    // UBAH DISINI: Ganti 'login' jadi '/'
    // Pas akses /internal/ dia langsung render halaman login
    Route::get('/', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    // Action POST login-nya kita samain aja ke '/' biar rapi, atau tetap 'login' bebas.
    // Disini gue set ke 'login' biar URL actionnya tetep jelas (POST /internal/login)
    Route::post('login', [AuthenticatedSessionController::class, 'store'])
        ->name('login.store');
});

// --- AUTHENTICATED ROUTES (Sudah Login) ---
Route::middleware('auth:employee')->group(function () {
    
    Route::get('/dashboard', DashboardController::class)
        ->name('dashboard');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // restore delete
    Route::post('users/{id}/restore', [Admin\UserController::class, 'restore'])->name('users.restore');
    Route::post('employees/{id}/restore', [Admin\EmployeeController::class, 'restore'])->name('employees.restore');

    Route::resources([
        'users' => Admin\UserController::class,
        'employees' => Admin\EmployeeController::class,
        'roles' => Admin\RoleController::class,
    ]);
});