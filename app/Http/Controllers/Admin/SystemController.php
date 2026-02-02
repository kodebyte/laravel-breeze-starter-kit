<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SystemController extends Controller
{
    public function index(): View
    {
        // 1. Cek Koneksi DB
        try {
            DB::connection()->getPdo();
            $dbStatus = true;
            $dbSize = $this->getDatabaseSize();
        } catch (\Exception $e) {
            $dbStatus = false;
            $dbSize = 'Unknown';
        }

        // 2. Cek Disk Usage
        $diskTotal = disk_total_space('/');
        $diskFree = disk_free_space('/');
        $diskUsed = $diskTotal - $diskFree;
        $diskPercentage = round(($diskUsed / $diskTotal) * 100);

        $serverInfo = [
            'php_version' => phpversion(),
            'laravel_version' => app()->version(),
            'server_os' => php_uname('s'),
            'server_ip' => $_SERVER['SERVER_ADDR'] ?? '127.0.0.1',
            'db_connection' => config('database.default'),
            'db_status' => $dbStatus,
            'db_size' => $dbSize,
            'disk_total' => $this->formatSize($diskTotal),
            'disk_free' => $this->formatSize($diskFree),
            'disk_used' => $this->formatSize($diskUsed),
            'disk_percentage' => $diskPercentage,
        ];

        return view('admin.system.index', compact('serverInfo'));
    }

    // Helper: Format Bytes ke Human Readable
    private function formatSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        for ($i = 0; $bytes > 1024; $i++) $bytes /= 1024;
        return round($bytes, 2) . ' ' . $units[$i];
    }

    // Helper: Get DB Size (MySQL Only)
    private function getDatabaseSize()
    {
        try {
            $dbName = config('database.connections.mysql.database');
            $result = DB::select("SELECT table_schema 'db_name', ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) 'size_mb' FROM information_schema.tables WHERE table_schema = ? GROUP BY table_schema", [$dbName]);
            
            return ($result[0]->size_mb ?? 0) . ' MB';
        } catch (\Exception $e) {
            return 'N/A';
        }
    }
}