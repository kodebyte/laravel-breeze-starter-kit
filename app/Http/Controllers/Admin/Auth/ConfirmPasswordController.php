<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ConfirmPasswordController extends Controller
{
    /**
     * Show the confirm password view.
     */
    public function show()
    {
        return view('admin.auth.confirm-password');
    }

    /**
     * Confirm the user's password.
     */
    public function store(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        if (! Hash::check($request->password, auth('employee')->user()->password)) {
            throw ValidationException::withMessages([
                'password' => __('The provided password does not match your current password.'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());

        // 🔥 UBAH DISINI: Kasih pesan "warning" atau "info"
        // Kita paksa balik ke Profile Edit dengan pesan instruksi
        return to_route('admin.profile.edit')
                    ->with('status', 'password-confirmed'); 
    }
}