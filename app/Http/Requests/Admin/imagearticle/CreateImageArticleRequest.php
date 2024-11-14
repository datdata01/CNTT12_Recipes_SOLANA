<?php

namespace App\Http\Requests\Admin\ImageArticle;

use Illuminate\Foundation\Http\FormRequest;

class CreateImageArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'images.required' => 'Ảnh không được để trống',
            'images.array' => 'Phải là một mảng ảnh',
            'images.*.image' => 'Phải đúng định dạng ảnh',
            'images.*.mimes' => 'Định dạng ảnh phải là jpeg, png, jpg, gif, svg',
            'images.*.max' => 'Kích thước ảnh phải nhỏ hơn 2MB',
        ];
    }
}
