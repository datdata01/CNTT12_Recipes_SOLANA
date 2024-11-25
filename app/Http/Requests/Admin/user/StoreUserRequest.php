<?php

namespace App\Http\Requests\Admin\user;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'full_name' =>'required|string|max:255',
            'email'     =>'required|email|unique:users,email',
            'password'  =>'required|string|min:8',
            'image'     =>'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone'     =>'required|digits_between:10,15',
            'status'    =>'required|in:ACTIVE,IN_ACTIVE',

            'roles'     => 'required|array', 
        ];
    }

    // Việt hóa thông báo lỗi
    public function messages(): array
    {
        return [
            'full_name.required' => 'Họ và tên là bắt buộc.',
            'full_name.max'      => 'Họ và tên không được vượt quá :max ký tự.',

            'email.required'     => 'Email là bắt buộc.',
            'email.email'        => 'Email không đúng định dạng.',
            'email.unique'       => 'Email đã tồn tại trong hệ thống.',

            'password.required'  => 'Mật khẩu là bắt buộc.',
            'password.min'       => 'Mật khẩu phải chứa ít nhất :min ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',

            'image.required'     => 'Ảnh đại diện là bắt buộc.',
            'image.image'        => 'File tải lên phải là hình ảnh.',
            'image.mimes'        => 'Ảnh đại diện phải có định dạng jpeg, png, jpg hoặc gif.',
            'image.max'          => 'Dung lượng ảnh đại diện không được vượt quá 2MB.',

            'phone.required'     => 'Số điện thoại là bắt buộc.',
            'phone.digits_between' => 'Số điện thoại phải có từ 10 đến 15 chữ số.',
            'phone.unique'       => 'Số điện thoại tồn tại trong hệ thống.',

            'status.required'    => 'Trạng thái là bắt buộc.',
            'status.in'          => 'Trạng thái phải là Hoạt động hoặc Ngưng hoạt động.',

            'roles.required'     => 'Vai trò là bắt buộc.',
        ];
    }

}
