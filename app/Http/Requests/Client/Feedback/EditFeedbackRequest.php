<?php

namespace App\Http\Requests\Client\Feedback;

use Illuminate\Foundation\Http\FormRequest;

class EditFeedbackRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Chỉnh sửa theo yêu cầu xác thực của bạn
    }

    public function rules()
    {
        return [
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:255',
            'file_path' => 'nullable|file|max:2048', // Tải lên file tùy chọn
        ];
    }

    public function messages()
    {
        return [
            'rating.required' => 'Bạn phải chọn số sao.',
            'rating.integer' => 'Đánh giá phải là một số nguyên.',
            'rating.between' => 'Đánh giá phải nằm trong khoảng từ 1 đến 5 sao.',
            'comment.max' => 'Bình luận không được vượt quá 255 ký tự.',
            'file_path.max' => 'Kích thước tệp tải lên không được vượt quá 2MB.',
        ];
    }
}
