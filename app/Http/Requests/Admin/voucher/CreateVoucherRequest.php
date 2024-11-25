<?php

namespace App\Http\Requests\Admin\voucher;

use Illuminate\Foundation\Http\FormRequest;

class CreateVoucherRequest extends FormRequest
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
            'name' => 'required',
            'code' => 'required|unique:vouchers,code',
            'description' => 'required',
            'limit' => 'required|integer|gt:0',
            'start_date' => 'required',
            'end_date' => 'required|after:start_date',
            'discount_type' => 'required',
            'discount_value' => 'required|numeric',
            'min_order_value' => 'required|numeric',
            'max_order_value' => 'required|numeric|gt:min_order_value',
            'status' => 'required',
            'limited_uses'=> 'nullable|numeric'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Không được bỏ trống trường dữ liệu',

            'code.required' => 'Không được bỏ trống trường dữ liệu',
            'code.unique' => 'Mã code đã tồn tại. Vui lòng chọn mã khác.',

            'description.required' => 'Không được bỏ trống trường dữ liệu',

            'limit.required' => 'Không được bỏ trống trường dữ liệu',
            'limit.gt' => 'Số lượng phải lớn hơn 0.',
            'limit.integer' => 'Số lượng phải là số nguyên.',

            'start_date.required' => 'Không được bỏ trống trường dữ liệu',

            'end_date.required' => 'Không được bỏ trống trường dữ liệu',
            'end_date.after' => 'Ngày kết thúc phải lớn hơn ngày bắt đầu.',

            'discount_type.required' => 'Không được bỏ trống trường dữ liệu',

            'discount_value.required' => 'Không được bỏ trống trường dữ liệu',
            'discount_value.numeric' => 'Giá trị giảm đang nhập sai kiểu dữ liệu.',


            'min_order_value.required' => 'Không được bỏ trống trường dữ liệu',
            'min_order_value.numeric' => 'Giá trị đơn hàng tối thiểu đang nhập sai kiểu dữ liệu.',

            'max_order_value.required' => 'Không được bỏ trống trường dữ liệu',
            'max_order_value.numeric' => 'Giá trị đơn hàng tối đa đang nhập sai kiểu dữ liệu.',
            'max_order_value.gt' => 'Giá trị tối đa phải lớn hơn giá trị tối thiểu.',

            'status.required' => 'Không được bỏ trống trường dữ liệu',

            'limited_uses.numeric' => 'Giới hạn sử dụng nhập sai kiểu dữ liệu'
        ];
    }
}
