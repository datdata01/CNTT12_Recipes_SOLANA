<?php

namespace App\Http\Requests\Admin\role;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
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
        $id = $this->route('role')->id;
        // dd($id);
        return [
            'name'        => 'required|max:50|unique:roles,name,' . $id,
            'description' => 'required|',
        ];
    }
    public function messages()
    {
        return [
            'name.required'   => 'Tên vai trò là bắt buộc.',
            'name.max'        => 'Tên vai trò không được vượt quá :max ký tự.',
            'name.unique'     => 'Tên vai trò đã tồn tại.',
            'description.required' => 'Mô tả vai trò là bắt buộc.',
        ];
    }
}
