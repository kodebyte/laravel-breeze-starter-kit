<?php

namespace App\Http\Requests\Admin\Employee;

use App\Enums\EmployeeStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Ambil ID employee dari route untuk ignore validasi unique
        $employeeId = $this->route('employee')->id;

        return [
            // Cek unik identifier tapi abaikan data milik sendiri
            'identifier' => [
                'required', 
                'string', 
                'max:50', 
                Rule::unique('employees')->ignore($employeeId)
            ],
            
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 
                'string', 
                'lowercase', 
                'email', 
                'max:255', 
                Rule::unique('employees')->ignore($employeeId)
            ],
            
            'role' => ['required', 'exists:roles,name'],
            'status' => ['required', new Enum(EmployeeStatus::class)],
            
            // Password jadi nullable pas update, diisi cuma kalau mau ganti
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ];
    }
}
