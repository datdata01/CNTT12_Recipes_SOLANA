<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ChangePassRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = Auth::user();

        return [
            'current_password' => 'required|string',
            'new_password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/', // Ít nhất một chữ cái thường
                'regex:/[A-Z]/', // Ít nhất một chữ cái hoa
                'regex:/[0-9]/', // Ít nhất một chữ số
                'regex:/[@$!%*?&]/', // Ít nhất một ký tự đặc biệt
                Rule::notIn([$user->password]),
            ],
            'new_password_confirmation' => 'required|string|min:8',
        ];
    }
    public function messages()
    {
        return [
            'current_password.required' => 'Vui lòng không bỏ trống.',
            'new_password.required' => 'Vui lòng không bỏ trống.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
            'new_password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'new_password.regex' => 'Mật khẩu mới phải chứa ít nhất một chữ cái thường, một chữ cái hoa, một chữ số và một ký tự đặc biệt.',
            'new_password_confirmation.required' => 'Vui lòng không bỏ trống.',
            'new_password_confirmation.min' => 'Xác nhận mật khẩu phải có ít nhất 8 ký tự.',
            'new_password.not_in' => 'Mật khẩu mới không được trùng với mật khẩu hiện tại.',
        ];
    }
}
