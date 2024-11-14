<?php

namespace App\Http\Requests\Client\profiles;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EditProfileRequest extends FormRequest
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
        return [
            'full_name' => 'required|string|max:50',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone'     => [
                'required',
                'string',
                'max:15',
                'unique:users,phone,' . Auth::user()->id,
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'Vui lòng nhập họ và tên.',
            'full_name.string'   => 'Họ và tên phải là chuỗi ký tự.',
            'full_name.max'      => 'Họ và tên không được vượt quá 50 ký tự.',

            'image.image'        => 'Tệp tải lên phải là hình ảnh.',
            'image.mimes'        => 'Ảnh đại diện chỉ hỗ trợ định dạng jpeg, png, jpg, gif.',
            'image.max'          => 'Kích thước ảnh đại diện không được vượt quá 2MB.',

            'phone.required'     => 'Vui lòng nhập số điện thoại.',
            'phone.string'       => 'Số điện thoại phải là chuỗi ký tự.',
            'phone.max'          => 'Số điện thoại không được vượt quá 15 ký tự.',
            'phone.unique'       => 'Số điện thoại này đã được sử dụng.',
        ];
    }
}
