<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Middleware sudah handle permission
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'array'],
            'name.id' => ['required', 'string', 'max:255'], // ID Wajib
            'name.en' => ['nullable', 'string', 'max:255'], // EN Opsional
            'is_active' => ['boolean'],
        ];
    }
}