<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request, $id)
    {
        // Lấy tất cả dữ liệu từ URL
        $requestData = $request->all();

        // dd(count($requestData));
        if (count($requestData) != 0) {

            // Kiểm tra và xác thực chữ ký (signature)
            $signature = $requestData['signature'];
            unset($requestData['signature']); // Xóa chữ ký khỏi dữ liệu

            // Tạo chuỗi rawHash để tính toán chữ ký từ các tham số
            $rawHash =
                "accessKey=" . env('MOMO_ACCESS_KEY') .
                "&amount=" . $requestData['amount'] .
                "&orderId=" . $requestData['orderId'] .
                "&orderInfo=" . $requestData['orderInfo'] .
                "&partnerCode=" . env("MOMO_PARTNER_CODE") .
                "&requestId=" . $requestData['requestId'] .
                "&requestType=" . $requestData['orderType'] .
                "&resultCode=" . $requestData['resultCode'] .
                "&message=" . $requestData['message'];

            $secretKey = env('MOMO_SECRET_KEY'); // Lấy secret key từ môi trường


            // Tính toán chữ ký từ rawHash
            $calculatedSignature = hash_hmac('sha256', $rawHash, $secretKey);
            $signature = hash_hmac("sha256", $rawHash, $secretKey);
            // dd($secretKey, $rawHash, $signature, $calculatedSignature);
            // Kiểm tra chữ ký
            if ($signature !== $calculatedSignature) {
                return response()->json(['error' => 'Invalid signature'], 400);
            }
            // neu giao dịch thanh cong thi doi trang thi don hang
            if ($requestData['resultCode']  == 0) { // ==0 thi la dung , khac 0 cho cook
                $data = Order::with('orderItems.productVariant.attributeValues.attribute', 'orderItems.productVariant.product')->findOrFail($id);
                $data->status = 'PENDING';
                $data->save();

                return view('client.pages.order-success.index', compact('data'));
            }

            return view('errors.404-client'); // thay bang trang thanh toan loi

        } else {
            $data = Order::with('orderItems.productVariant.attributeValues.attribute', 'orderItems.productVariant.product')->findOrFail($id);
            return view('client.pages.order-success.index', compact('data'));
        }
    }
}
