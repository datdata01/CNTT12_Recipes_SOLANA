<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePermissionRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:permissions,name',
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên quyền không được để trống.',
            'name.string'   => 'Tên quyền phải là một chuỗi ký tự.',
            'name.max'      => 'Tên quyền không được vượt quá 255 ký tự.',
            'name.unique'   => 'Tên quyền đã tồn tại.',
        ];
    }
}
