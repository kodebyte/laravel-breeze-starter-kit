<?php

namespace App\Http\Requests\Admin\Menu;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Permission udah dihandle Middleware Controller
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'label.id' => ['required', 'string'],
            'type'     => ['required', 'in:page,custom'],
            
            // Logic Conditional: Kalau type=page, page_id wajib.
            'page_id'  => ['nullable', 'exists:pages,id', 'required_if:type,page'],
            
            // Logic Conditional: Kalau type=custom, url wajib.
            'url'      => ['nullable', 'string', 'required_if:type,custom'],
            
            'target'   => ['nullable', 'in:_self,_blank'],
        ];
    }

    /**
     * Custom messages biar user gak bingung kalau error
     */
    public function messages(): array
    {
        return [
            'page_id.required_if' => 'Please select a page from the list.',
            'url.required_if'     => 'The URL field is required for custom links.',
            'label.id.required'   => 'The menu label is required.',
        ];
    }
}