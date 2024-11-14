<?php

namespace App\Http\Requests\Client\placeOrder;

use Illuminate\Foundation\Http\FormRequest;

class CreatePlaceOrderRequest extends FormRequest
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
            "address_user_id" => "required",
            "total_amount" => "required",
            "payment_method" => "required",
            "note" => "nullable",
        ];
    }

    public function messages()
    {
        return [
            "address_user_id.required" => "Không được để trống địa chỉ",
            "totalAmount.required" => "Không được để trống tổng số tiền",
            "payment_method.required" => "Không được để trống phương thức thanh toán",
            "note.required" => "Không được để trống ghi chú"
        ];
    }
}
