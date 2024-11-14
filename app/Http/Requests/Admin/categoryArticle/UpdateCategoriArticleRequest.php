<?php

namespace App\Http\Requests\Admin\categoryArticle;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoriArticleRequest extends FormRequest
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
        $id = $this->route('category_article');
        return [
            "name"=> "required|min:3|max:50|unique:category_articles,name," .$id,
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Tên là bắt buộc.',
            'name.unique' => 'Tên đã tồn tại.',
            'name.min' => 'Tên phải có ít nhất 3 ký tự.',
            'name.max' => 'Tên không được vượt quá 50 ký tự.',
        ];
    }
}
