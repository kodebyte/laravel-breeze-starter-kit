<?php

namespace App\Http\Requests\Admin\Banner;

use Illuminate\Foundation\Http\FormRequest;

class StoreBannerRequest extends FormRequest
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
        return [
            'zone' => ['required', 'string'],
            'type' => ['required', 'in:image,video'],
            
            // Validasi Gambar (Desktop Wajib)
            'image_desktop' => ['required', 'image', 'max:2048'], // Max 2MB
            'image_mobile' => ['nullable', 'image', 'max:2048'],
            
            // Validasi Video (Wajib jika type=video)
            'video' => ['nullable', 'required_if:type,video', 'mimes:mp4', 'max:10240'], // Max 10MB
            
            'title' => ['nullable', 'string', 'max:255'],
            'cta_url' => ['nullable', 'url'],
            'order' => ['nullable', 'integer'],
            'is_active' => ['boolean'],
        ];
    }
}
