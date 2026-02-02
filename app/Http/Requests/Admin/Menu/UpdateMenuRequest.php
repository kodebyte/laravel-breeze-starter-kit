<?php

namespace App\Http\Requests\Admin\Menu;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'is_active' => ['nullable', 'boolean'],
            'label.id'  => ['nullable', 'string'],
            'url'       => ['nullable', 'string'],
            'target'    => ['nullable', 'in:_self,_blank'],
        ];
    }
}