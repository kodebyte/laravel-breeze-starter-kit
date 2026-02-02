<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting; 

class GoogleDriveServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Bungkus try-catch biar aman pas artisan command jalan
        try {
            // Cek dulu tabelnya ada gak (buat safety pas migrasi)
            if (Schema::hasTable('settings')) {
                
                $clientId     = Setting::get('backup_google_client_id');
                $clientSecret = Setting::get('backup_google_client_secret');
                $refreshToken = Setting::get('backup_google_refresh_token');
                $folderId     = Setting::get('backup_google_folder_id');

                // KUNCI SUKSESNYA DISINI BRO:
                // Kita "Timpa" config yang tadi kosong dengan data dari DB
                if ($clientId && $clientSecret && $refreshToken) {
                    
                    // 1. Inject ke Filesystem
                    Config::set('filesystems.disks.google.clientId', $clientId);
                    Config::set('filesystems.disks.google.clientSecret', $clientSecret);
                    Config::set('filesystems.disks.google.refreshToken', $refreshToken);
                    Config::set('filesystems.disks.google.folderId', $folderId);

                    // 2. Pastikan Backup Spatie pake disk 'google' juga
                    // (Opsional: Bisa dilogika kalau user enable dual backup baru ditambahin)
                    $currentDisks = Config::get('backup.backup.destination.disks');
                    if (!in_array('google', $currentDisks)) {
                        $currentDisks[] = 'google';
                        Config::set('backup.backup.destination.disks', $currentDisks);
                    }
                }
            }
        } catch (\Throwable $e) {
            // Silent error: Kalau DB belum connect, biarin aja pake config default (.env)
        }
    }
}