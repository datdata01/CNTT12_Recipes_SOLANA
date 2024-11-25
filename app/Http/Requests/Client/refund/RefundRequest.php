<?php

namespace App\Http\Requests\Client\refund;

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
            'quantity' => 'required',
            'reason' => 'required',
            'description' => 'required',
            'image' => 'required', 
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
            'quantity.required' => 'Không được bỏ trống số lượng sản phẩm',

            'reason.required' => 'Lý do hoàn hàng là bắt buộc.',

            'description.required' => 'Mô tả không được bỏ trống.',

            'image.required' => 'Ảnh là bắt buộc',

        ];
    }
}
