<?php

namespace App\Http\Requests\Admin\attributes;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttributeRequest extends FormRequest
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
        $id = $this->route('attributes');
        return [
             'name' => 'required|string|max:100|regex:/^[\p{L}0-9\s]+$/u|unique:attributes,name'.$id,
        ];
    }
    public function messages()
    {
        return[
            'name.required' => 'Trường tên là bắt buộc.',
            'name.regex'=>'không chứa ký tự.',
            'name.unique' => 'Tên đã được tồn tại'
        ];
    }
}
