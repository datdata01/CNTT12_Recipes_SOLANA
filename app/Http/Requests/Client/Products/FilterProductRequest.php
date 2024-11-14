<?php

namespace App\Http\Requests\Client\Products;

use Illuminate\Foundation\Http\FormRequest;

class FilterProductRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Để cho phép mọi người gửi request
    }

    public function rules()
    {
        return [
            'categories' => 'array', // Danh sách category là một mảng
            'categories.*' => 'integer|exists:category_products,id', // Mỗi phần tử trong mảng phải là số nguyên và tồn tại trong bảng category_products
            'attributes' => 'array', // Danh sách attribute là một mảng
            'attributes.*' => 'integer|exists:attribute_values,id', // Mỗi phần tử trong mảng phải là số nguyên và tồn tại trong bảng attribute_values
            'minPrice' => 'numeric|min:0', // Giá tối thiểu phải là số và không âm
            'maxPrice' => 'numeric|min:0', // Giá tối đa phải là số và không âm
        ];
    }

    public function messages()
    {
        return [
            'categories.array' => 'Danh mục phải là một mảng.',
            'categories.*.integer' => 'Mỗi danh mục phải là một số nguyên.',
            'categories.*.exists' => 'Danh mục không tồn tại.',
            'attributes.array' => 'Thuộc tính phải là một mảng.',
            'attributes.*.integer' => 'Mỗi thuộc tính phải là một số nguyên.',
            'attributes.*.exists' => 'Thuộc tính không tồn tại.',
            'minPrice.numeric' => 'Giá tối thiểu phải là một số.',
            'maxPrice.numeric' => 'Giá tối đa phải là một số.',
            'minPrice.min' => 'Giá tối thiểu không thể âm.',
            'maxPrice.min' => 'Giá tối đa không thể âm.',
        ];
    }
}
