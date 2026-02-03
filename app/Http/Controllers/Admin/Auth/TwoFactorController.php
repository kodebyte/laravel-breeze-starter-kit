<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;

class TwoFactorController extends Controller
{
    /**
     * Enable Two Factor Authentication.
     */
    public function store(Request $request, EnableTwoFactorAuthentication $enable)
    {
        // 1. Eksekusi Action Bawaan Fortify
        // Kita oper user yang sedang login (Employee)
        $enable(auth('employee')->user(), $request->boolean('force'));

        // 2. Redirect Paksa ke Profile Edit (Bukan back())
        return to_route('admin.profile.edit') // <--- INI KUNCINYA
                ->with('status', 'two-factor-authentication-enabled');
    }

    /**
     * Disable Two Factor Authentication.
     */
    public function destroy(Request $request, DisableTwoFactorAuthentication $disable)
    {
        // 1. Eksekusi Action Bawaan Fortify
        $disable(auth('employee')->user());

        // 2. Redirect Paksa ke Profile Edit
        return to_route('admin.profile.edit') // <--- INI KUNCINYA
            ->with('status', 'two-factor-authentication-disabled');
    }
}