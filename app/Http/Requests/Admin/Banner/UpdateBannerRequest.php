<?php

namespace App\Http\Requests\Admin\Banner;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Banner;

class UpdateBannerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Ambil list zona valid dari config buat validasi
        $validZones = array_keys(Banner::getZones());

        return [
            'zone' => ['required', 'string', 'in:' . implode(',', $validZones)],
            'type' => ['required', 'in:image,video'],
            
            // Image Desktop (Nullable pas update, kalau kosong berarti pake yg lama)
            'image_desktop' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            
            // Image Mobile
            'image_mobile' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            
            // Video (Nullable, Max 10MB)
            'video' => ['nullable', 'required_if:type,video', 'mimes:mp4', 'max:10240'], 
            
            'title.id' => ['nullable', 'string', 'max:255'],
            'title.en' => ['nullable', 'string', 'max:255'],

            'subtitle.id' => ['nullable', 'string', 'max:500'],
            'subtitle.en' => ['nullable', 'string', 'max:500'],

            'cta_text.id' => ['nullable', 'string', 'max:50'],
            'cta_text.en' => ['nullable', 'string', 'max:50'],
            
            'cta_url' => ['nullable', 'url', 'max:255'],
            'order' => ['nullable', 'integer'],
            'is_active' => ['boolean'],
        ];
    }
}