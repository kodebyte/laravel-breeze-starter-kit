<?php

namespace App\Http\Requests\Admin\Page;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Middleware controller sudah handle permission
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // 1. Validasi Content (Multi-bahasa)
            // Array content bisa null, tapi kalau ada isinya harus string
            'content'    => ['nullable', 'array'],
            'content.id' => ['nullable', 'string'],
            'content.en' => ['nullable', 'string'],

            // 2. Validasi SEO Image
            // Max 2MB, harus gambar
            'seo_image'  => ['nullable', 'image', 'max:2048'], 

            // 3. SEO Data (Meta Title/Desc dari package)
            'seo'        => ['nullable', 'array'],

            'seo.robots' => ['nullable', 'string'],
        ];
    }
}