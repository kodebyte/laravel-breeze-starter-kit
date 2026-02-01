<?php

namespace App\Http\Requests\Admin\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ForcePasswordUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Karena sudah lewat middleware auth:employee, kita set true saja
        return true;
    }

    public function rules(): array
    {
        return [
            'password' => [
                'required', 
                'confirmed', 
                Password::min(8)
                    ->letters()
                    ->numbers()
                    ->uncompromised(), // Bonus: Cek apakah password pernah bocor di internet
            ],
        ];
    }
}