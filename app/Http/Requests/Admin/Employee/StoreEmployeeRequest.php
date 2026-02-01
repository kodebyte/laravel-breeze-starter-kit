<?php

namespace App\Http\Requests\Admin\Employee;

use App\Enums\EmployeeStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Identifier: Wajib, string, max 50, dan harus unik di tabel employees
            'identifier' => ['required', 'string', 'max:50', 'unique:employees,identifier'],
            
            'name' => ['required', 'string', 'max:255'],
            
            // Email: Unik di tabel employees
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:employees,email'],
            
            // Role: Cek apakah nama role ada di tabel roles
            'role' => ['required', 'exists:roles,name'],
            
            // Status: Validasi pakai Enum
            'status' => ['required', new Enum(EmployeeStatus::class)],
            
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }
}