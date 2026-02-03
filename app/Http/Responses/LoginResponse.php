<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Contracts\TwoFactorLoginResponse as TwoFactorLoginResponseContract;

class LoginResponse implements LoginResponseContract, TwoFactorLoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        // Cek apakah yang login adalah employee/admin
        if ($request->wantsJson()) {
            return response()->json(['two_factor' => false]);
        }

        // REDIRECT KE DASHBOARD ADMIN
        return redirect()->route('admin.dashboard');
    }
}