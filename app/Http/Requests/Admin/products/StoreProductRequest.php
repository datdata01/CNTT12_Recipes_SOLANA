<?php

namespace App\Http\Requests\Admin\products;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name'                => 'required|string|max:255',
            'code'                => 'required|string|max:50|unique:products,code,',
            'description'         => 'nullable|string',
            'category_product_id' => 'required|exists:category_products,id',
            'status'              => 'required|in:ACTIVE,IN_ACTIVE',
            'image'               => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'image_url'           => 'nullable|array',
            'image_url.*'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            'variants'            => 'nullable|array',
            'variants.*.price'    => 'required|numeric|min:0',
            'variants.*.quantity' => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'                => 'Tên sản phẩm là bắt buộc.',
            'name.string'                  => 'Tên sản phẩm phải là một chuỗi.',
            'name.max'                     => 'Tên sản phẩm không được vượt quá 255 ký tự.',

            'code.required'                => 'Mã sản phẩm là bắt buộc.',
            'code.string'                  => 'Mã sản phẩm phải là một chuỗi.',
            'code.max'                     => 'Mã sản phẩm không được vượt quá 50 ký tự.',
            'code.unique'                  => 'Mã sản phẩm đã tồn tại, vui lòng chọn mã khác.',

            'description.string'           => 'Mô tả phải là một chuỗi.',

            'category_product_id.required' => 'Danh mục sản phẩm là bắt buộc.',
            'category_product_id.exists'   => 'Danh mục sản phẩm không hợp lệ.',

            'status.required'              => 'Trạng thái sản phẩm là bắt buộc.',
            'status.in'                    => 'Trạng thái sản phẩm không hợp lệ.',

            'image.required'               => 'Ảnh sản phẩm là bắt buộc.',
            'image.image'                  => 'Ảnh sản phẩm phải là một tệp hình ảnh.',
            'image.mimes'                  => 'Ảnh sản phẩm phải là tệp loại: jpeg, png, jpg, gif.',
            'image.max'                    => 'Ảnh sản phẩm không được vượt quá 2MB.',

            'image_url.required'           => 'Album ảnh sản phẩm là bắt buộc.',
            'image_url.array'              => 'Album ảnh sản phẩm phải là một mảng tệp hình ảnh.',
            'image_url.*.image'            => 'Mỗi ảnh trong album phải là một tệp hình ảnh.',
            'image_url.*.mimes'            => 'Ảnh trong album phải là tệp loại: jpeg, png, jpg, gif.',
            'image_url.*.max'              => 'Mỗi ảnh trong album không được vượt quá 2MB.',

            'variants.array'               => 'Biến thể sản phẩm phải là một mảng.',
            'variants.*.price.required'    => 'Giá của biến thể là bắt buộc.',
            'variants.*.price.numeric'     => 'Giá của biến thể phải là số.',
            'variants.*.price.min'         => 'Giá của biến thể không được nhỏ hơn 0.',

            'variants.*.quantity.required' => 'Số lượng của biến thể là bắt buộc.',
            'variants.*.quantity.integer'  => 'Số lượng của biến thể phải là số nguyên.',
            'variants.*.quantity.min'      => 'Số lượng của biến thể không được nhỏ hơn 0.',
        ];
    }
}
