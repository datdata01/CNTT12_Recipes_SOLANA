<?php

namespace App\Http\Requests\Admin\attributeValue;

use Illuminate\Foundation\Http\FormRequest;

class AttributeValueRequest extends FormRequest
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
        $id = $this->route('attributeValues');
        return [
             'attribute_id' => 'required|exists:attributes,id',
              'name' => 'required|string|max:100|regex:/^[\p{L}0-9\s:\/]+$/u|unique:attribute_values,name'.$id,
        ];
    }

    public function messages()
    {
        return[
            'attribute_id' => 'Trường thuộc tính không được để trống',      
            'name.required' => 'Trường tên là bắt buộc.',
            'name.regex' => 'không chứa kí tự',
            'name.unique' => 'Tên đã tồn tại'
        ];
    }
}
