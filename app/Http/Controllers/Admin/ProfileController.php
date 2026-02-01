<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\ForcePasswordUpdateRequest;
use App\Http\Requests\Admin\Profile\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan Form Edit Profil
     */
    public function edit(): View
    {
        // Ambil data employee yang sedang login
        $employee = auth()->user();

        return view('admin.profile.edit', compact('employee'));
    }

    /**
     * Proses Update Profil
     */
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        try {
            $employee = auth()->user();
            
            // 1. Update Atribut Dasar
            $employee->name = $request->name;
            $employee->email = $request->email;

            // 2. Update Password (jika diisi)
            if ($request->filled('password')) {
                $employee->password = Hash::make($request->password);
            }

            $employee->save(); // Single Query Save sesuai standard kita

            return back()->with('success', 'Profile updated successfully!');

        } catch (\Throwable $e) {
            // LOG ERROR: Wajib ada sesuai instruksi lo bro
            Log::error('Error updating profile for Employee ID ' . auth()->id() . ': ' . $e->getMessage());

            return back()->withInput()->with('error', 'Failed to update profile. Please try again.');
        }
    }

    public function forceChangeIndex()
    {
        return view('admin.profile.force-password');
    }

    public function forceChangeUpdate(ForcePasswordUpdateRequest $request)
    {
        // Validasi sudah otomatis berjalan sebelum masuk ke sini
        $user = auth()->guard('employee')->user();
        
        $user->update([
            'password' => Hash::make($request->password),
            'must_change_password' => false,
        ]);

        return to_route('admin.dashboard')
                ->with('success', 'Password updated successfully! You now have full access to the system.');
    }
}