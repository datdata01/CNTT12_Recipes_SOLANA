<?php

namespace App\Http\Requests\Client\AddressUser;

use Illuminate\Foundation\Http\FormRequest;

class AddressUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Cho phép tất cả người dùng thực hiện yêu cầu này
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric',
            'province_id' => 'required|exists:provinces,id',
            'district_id' => 'required|exists:districts,id',
            'ward_id' => 'required|exists:wards,id',
            'address_detail' => 'required|string|max:255',
            'default' => 'nullable|boolean', // Không cần 'required' vì nó có thể không có
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Không được để trống',
            'phone.required' => 'Không được để trống số điện thoại',
            'province_id.required' => 'Không được để trống',
            'district_id.required' => 'Không được để trống',
            'ward_id.required' => 'Không được để trống',
            'address_detail.required' => 'Không được để trống',
        ];
    }
}
