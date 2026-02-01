<?php

namespace App\Http\Requests\Admin\Employee;

use App\Enums\EmployeeStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
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
            'identifier' => ['required', 'string', 'max:50', Rule::unique('employees', 'identifier')],
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', Rule::unique('employees', 'email')],
            'role'       => ['required', 'exists:roles,name'],
            'status'     => ['required', Rule::enum(EmployeeStatus::class)],
        ];
    }
}