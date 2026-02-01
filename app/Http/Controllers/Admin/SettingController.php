<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        // Ambil semua input kecuali token dan method
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            // 1. Cek apakah inputan berupa FILE (Logo/Favicon)
            if ($request->hasFile($key)) {
                // Hapus foto lama kalau ada biar gak nyampah di storage
                $oldPath = Setting::get($key);
                if ($oldPath) {
                    Storage::disk('public')->delete($oldPath);
                }

                // Simpan file baru
                $value = $request->file($key)->store('settings', 'public');
            }

            // 2. Simpan atau Update ke Database
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'General settings have been successfully updated.');
    }
}