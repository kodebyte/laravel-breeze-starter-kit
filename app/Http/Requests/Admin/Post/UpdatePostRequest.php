<?php

namespace App\Http\Requests\Admin\Post;

use App\Enums\PostStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'array'],
            'title.id' => ['required', 'string', 'max:255'],
            'title.en' => ['nullable', 'string', 'max:255'],
            
            'excerpt' => ['nullable', 'array'],
            'excerpt.id' => ['nullable', 'string', 'max:500'],
            'excerpt.en' => ['nullable', 'string', 'max:500'],

            'content' => ['required', 'array'],
            'content.id' => ['required', 'string'],
            'content.en' => ['nullable', 'string'],

            'category_id' => ['required', 'exists:categories,id'],
            'status' => ['required', new Enum(PostStatus::class)],
            'published_at' => ['nullable', 'date'],
            
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            
            // Allow slug update manual
            'slug' => ['nullable', 'string', 'unique:posts,slug,' . $this->post->id],
        ];
    }
}