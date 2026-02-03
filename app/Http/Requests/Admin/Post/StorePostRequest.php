<?php

namespace App\Http\Requests\Admin\Post;

use App\Enums\PostStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Multi-language Content
            'title' => ['required', 'array'],
            'title.id' => ['required', 'string', 'max:255'],
            'title.en' => ['nullable', 'string', 'max:255'],
            
            'excerpt' => ['nullable', 'array'],
            'excerpt.id' => ['nullable', 'string', 'max:500'],
            'excerpt.en' => ['nullable', 'string', 'max:500'],

            'content' => ['required', 'array'],
            'content.id' => ['required', 'string'], // WYSIWYG biasanya string HTML panjang
            'content.en' => ['nullable', 'string'],

            // Meta Data
            'category_id' => ['required', 'exists:categories,id'],
            'status' => ['required', new Enum(PostStatus::class)],
            'published_at' => ['nullable', 'date'],
            
            // Image (Max 2MB)
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}