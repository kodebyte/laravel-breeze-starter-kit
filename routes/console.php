<?php

use App\Models\Setting;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Schema;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/**
 * Logic database dipindah ke dalam 'when'. 
 * Ini AMAN karena tidak dieksekusi saat artisan booting.
 */

Schedule::command('backup:clean')
    ->dailyAt('01:00')
    ->withoutOverlapping()
    ->when(function () {
        return Schema::hasTable('settings') && Setting::get('backup_daily_active');
    });

Schedule::command('backup:run --only-db --disable-notifications')
    ->dailyAt('01:30')
    ->withoutOverlapping()
    ->when(function () {
        return Schema::hasTable('settings') && Setting::get('backup_daily_active');
    });