<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function index()
    {
        // Default disk spatie/laravel-backup biasanya 'local' atau 's3'
        // Sesuaikan dengan config/backup.php lo
        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);
        $files = $disk->files(config('backup.backup.name'));

        $backups = [];

        // Loop file backup biar jadi array rapi
        foreach ($files as $k => $f) {
            // Hanya ambil file .zip
            if (substr($f, -4) == '.zip' && $disk->exists($f)) {
                $backups[] = [
                    'path' => $f,
                    'name' => str_replace(config('backup.backup.name') . '/', '', $f),
                    'size' => $this->humanFilesize($disk->size($f)),
                    'date' => \Carbon\Carbon::createFromTimestamp($disk->lastModified($f)),
                ];
            }
        }

        // Sort by date descending (terbaru diatas)
        $backups = collect($backups)->sortByDesc('date');

        return view('admin.backups.index', compact('backups'));
    }

    public function create()
    {
        try {
            // Jalanin command artisan backup:run
            // Opsi: --only-db biar cepet, atau full backup
            Artisan::call('backup:run --only-db');
            
            return redirect()->back()->with('success', 'New backup created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Backup failed: ' . $e->getMessage());
        }
    }

    public function download($fileName)
    {
        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);
        $path = config('backup.backup.name') . '/' . $fileName;

        if ($disk->exists($path)) {
            /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
            return $disk->download($path);
        }

        return redirect()->back()->with('error', 'Backup file not found.');
    }

    public function destroy($fileName)
    {
        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);
        $path = config('backup.backup.name') . '/' . $fileName;

        if ($disk->exists($path)) {
            $disk->delete($path);
            return redirect()->back()->with('success', 'Backup deleted successfully.');
        }

        return redirect()->back()->with('error', 'Backup file not found.');
    }

    // Helper buat format Size (KB, MB, GB)
    private function humanFilesize($bytes, $decimals = 2)
    {
        $sz = 'BKMGTP';
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
    }
}