<?php

namespace App\Http\Requests\Client\Feedback;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Bạn có thể thêm logic xác thực người dùng ở đây
    }

    public function rules()
    {
        return [
            'order_item_id' => 'required|exists:order_items,id',
            'user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
            'file_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => 'Sản phẩm là bắt buộc.',
            'user_id.required' => 'Người dùng là bắt buộc.',
            'rating.required' => 'Đánh giá là bắt buộc.',
            'comment.required' => 'Nội dung đánh giá là bắt buộc.',
            // Thêm các thông báo lỗi khác nếu cần
        ];
    }
}
