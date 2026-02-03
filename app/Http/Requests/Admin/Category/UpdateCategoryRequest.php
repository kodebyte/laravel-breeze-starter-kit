<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'array'],
            'name.id' => ['required', 'string', 'max:255'],
            'name.en' => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
            // Slug boleh diedit pas update (optional, tapi best practice biasanya jangan sering2 ganti slug)
            'slug' => ['nullable', 'string', 'unique:categories,slug,' . $this->category->id],
        ];
    }
}