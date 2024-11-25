<?php

namespace App\Http\Requests\Admin\refund;

use Illuminate\Foundation\Http\FormRequest;

class RefundRequest extends FormRequest
{
    /**
     * Xác thực người dùng có quyền gửi yêu cầu này hay không.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Đặt là true nếu tất cả người dùng đều có quyền gửi yêu cầu này
    }

    /**
     * Lấy các quy tắc xác thực cho yêu cầu này.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'order_code' => 'required|string|exists:orders,code',
            'reason' => 'required|in:NOT_RECEIVED,MISSING_ITEMS,DAMAGED_ITEMS,INCORRECT_ITEMS,FAULTY_ITEMS,DIFFERENT_FRON_THE_DESCRIPTION,USED_ITEMS',
            'description' => 'nullable|string|max:500',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048', // Kiểm tra ảnh
        ];
    }

    /**
     * Các thông báo lỗi tùy chỉnh.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'order_code.required' => 'Mã đơn hàng là bắt buộc.',
            'order_code.exists' => 'Mã đơn hàng không tồn tại.',
            'reason.required' => 'Lý do hoàn hàng là bắt buộc.',
            'image.required'=> 'Ảnh là bắt buộc',
            'image.image' => 'Tệp tải lên phải là một ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng jpg, jpeg, png hoặc gif.',
            'image.max' => 'Ảnh không được quá 2MB.',
        ];
    }
}
