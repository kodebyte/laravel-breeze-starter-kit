<?php

use App\Models\Setting;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

try {
    // Cek apakah fitur aktif di database
    // (Pastikan Model Setting udah ada & tabel udah dimigrasi)
    $backupActive = false;
    
    // Pengecekan aman biar gak error "Base table or view not found" pas fresh install
    if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
        $backupActive = Setting::get('backup_daily_active');
    }

    if ($backupActive) {
        // 1. Bersihkan backup lama (biar disk gak penuh) jam 01:00
        Schedule::command('backup:clean')
                ->dailyAt('01:00')
                ->withoutOverlapping();

        // 2. Jalankan backup baru jam 01:30
        // --only-db biar cepet. Hapus flag ini kalau mau file project juga.
        Schedule::command('backup:run --only-db --disable-notifications')
                ->dailyAt('01:30')
                ->withoutOverlapping();
    }
} catch (\Exception $e) {
    // Silent error: biar gak ngerusak artisan command lain
}