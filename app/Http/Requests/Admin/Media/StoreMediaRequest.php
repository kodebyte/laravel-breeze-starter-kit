<?php

namespace App\Http\Requests\Admin\Media;

use Illuminate\Foundation\Http\FormRequest;

class StoreMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Sesuaikan permission kalau perlu, default true dulu
        return true; 
    }

    public function rules(): array
    {
        return [
            'file' => ['required', 'file', 'max:10240'], // Max 10MB
        ];
    }
}