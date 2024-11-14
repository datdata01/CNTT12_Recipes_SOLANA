<?php

namespace App\Http\Requests\Admin\article;

use Illuminate\Foundation\Http\FormRequest;

class  CreateArticleRequest  extends FormRequest
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
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_article_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Tiêu đề bắt buộc.',
            'title.string' => 'Tiêu đề phải là chuỗi',
            'title.max' => 'Tiêu đề không quá 255 ký tự',

            'category_article_id.required' => 'Không được để trống ',

            'content.required' => 'Nội dung không được để trống',
            'content.string' => 'Nội dung phải là chuỗi',
            'image.required' => 'Ảnh không được để trống',
            'image.image' => 'Phải đúng định dạng ảnh',
            'image.mimes' => 'Định dạng ảnh phải là jpeg, png, jpg, gif, svg',
            'image.max' => 'Kích thước ảnh phải nhỏ hơn 2MB',
        ];
    }
}
