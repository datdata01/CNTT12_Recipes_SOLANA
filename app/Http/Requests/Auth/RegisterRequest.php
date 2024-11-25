<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
            'full_name' => [
                'required',
                'string',
                'max:40',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/', // Ít nhất một chữ cái thường
                'regex:/[A-Z]/', // Ít nhất một chữ cái hoa
                'regex:/[0-9]/', // Ít nhất một chữ số
                'regex:/[@$!%*?&]/', // Ít nhất một ký tự đặc biệt
            ],
            'password_confirmation' => [
                'required_with:password',
                'same:password',
            ],
            'phone' => [
                'required',
                'string',
                'unique:users,phone',
                'regex:/^[0-9]{10,15}$/', // Số từ 10 đến 15 chữ số
            ],
            'image' => 'nullable|string',
            'status' => 'nullable|string',
            'agree_terms' => 'accepted',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'full_name.required' => 'Họ và tên là bắt buộc.',
            'full_name.max' => 'Họ và tên chỉ được chứa tối đa 40 ký tự.',

            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ. Vui lòng nhập đúng định dạng.',
            'email.unique' => 'Email đã tồn tại.',
            'email.max' => 'Email không được dài quá 255 ký tự.',

            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.unique' => 'Số điện thoại đã tồn tại.',
            'phone.regex' => 'Số điện thoại phải là số và có độ dài từ 10 đến 15 ký tự.',

            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.regex' => 'Mật khẩu phải chứa ít nhất một chữ cái thường, một chữ cái hoa, một chữ số và một ký tự đặc biệt.',

            'password_confirmation.required_with' => 'Bạn phải xác nhận mật khẩu.',
            'password_confirmation.same' => 'Xác nhận mật khẩu không trùng khớp.',

            'agree_terms.accepted' => 'Bạn cần đồng ý với điều khoản và dịch vụ.',
        ];
    }
    public function prepareForValidation()
    {
        // Xóa khoảng trắng thừa và chỉ giữ lại một khoảng trắng giữa các từ
        $this->merge([
            'full_name' => preg_replace('/\s+/', ' ', trim($this->full_name)),
        ]);
    }
}
