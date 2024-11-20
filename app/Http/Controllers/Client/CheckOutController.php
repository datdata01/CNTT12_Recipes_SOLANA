<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\placeOrder\CreateOrderBuyNow;
use App\Http\Requests\Client\placeOrder\CreatePlaceOrderRequest;
use App\Models\AddressUser;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use App\Models\Province;
use App\Models\Voucher;
use App\Models\VoucherUsage;
use Exception;
use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isEmpty;

class CheckOutController extends Controller
{
    public function checkOutByCart()
    {
        $userId = Auth::id();
        $productCarts = Cart::with(['productVariant.product', 'productVariant.attributeValues.attribute'])->where('user_id', $userId)->get()->toArray();
        // dd($productCarts);
        $productResponse = [];
        foreach ($productCarts as $key => $value) {
            $productResponse[$key] = [];
            foreach ($productCarts as $key => $productCart) {
                $productResponse[$key]['cart'] = $productCart;
                $productResponse[$key]['product_variant'] = $productCart['product_variant'];
                $productResponse[$key]['product'] = $productCart['product_variant']['product'];
            }
        }
        // dd($productResponse);
        $userAddress = AddressUser::where('user_id', $userId)->get();
        $provinces = Province::all();
        $voucher = VoucherUsage::with('voucher')
            ->where('user_id', Auth::id())
            ->Where('end_date', '>', Carbon::now())
            ->Where('status', 'ACTIVE')
            ->whereHas('voucher', function ($query) {        // Lọc các voucher có limit > 0
                $query->where('limit', '>', 0);               // Điều kiện limit > 0
            })
            ->latest('id')
            ->get();

        return view('client.pages.check-out.index', [
            'productResponse' => $productResponse,
            'userAddress' => $userAddress,
            'provinces' => $provinces,
            'voucher' => $voucher
        ]);
    }

    public function checkOutByNow()
    {

        $userId = Auth::id();
        $userAddress = AddressUser::where('user_id', $userId)->get();
        $provinces = Province::all();
        return view('client.pages.check-out.check-out-buy-now', [
            'userAddress' => $userAddress,
            'provinces' => $provinces
        ]);
    }

    public function placeOrder(CreatePlaceOrderRequest $request)
    {
        // dd($request->all());
        $userId = Auth::id();
        $productCarts = Cart::with(['productVariant.product', 'productVariant.attributeValues.attribute'])->where('user_id', $userId)->get();
        // dd($productCarts->toArray());
        // dd($request->payment_method);
        try {
            DB::beginTransaction();
            $paymentMethod = null;
            if ($request->payment_method == 'momo' || $request->payment_method == 'vnpay') {
                $paymentMethod = "BANK_TRANSFER";
            } else {
                $paymentMethod = "CASH";
            }

            foreach ($productCarts as $key => $item) {
                $quantity = $item->productVariant->quantity - $item->quantity;
                $sold = $item->productVariant->sold + $item->quantity;
                // dd($item->productVariant->sold);
                // Cập nhật lại số lượng trong bảng product_variants

                $item->productVariant->quantity = $quantity; // cap nhat lai so luong ton kho
                $item->productVariant->sold = $sold; // cap nhat so luong da ban
                $item->productVariant->save();
            }

            // Kiểm tra kết quả sau khi cập nhật
            $productCarts = $productCarts->toArray();

            // lay du lieu dia chi nguoi nhan
            $addressUser = AddressUser::with(['province', 'district', 'ward'])->where('id', $request->address_user_id)->first()->toArray();

            $fullAddress = $addressUser['address_detail'] . " - " . $addressUser['ward']['name']
                . " - " . $addressUser['district']['name'] . " - " . $addressUser['province']['name'];

            // ma don hang
            $code = $this->codeOrder();
            // dd($fullAddress);
            $dataOrder = [
                "user_id" => $userId,
                "total_amount" => $request->total_amount,
                "payment_method" => $paymentMethod,
                "note" => $request->note,
                "confirm_status" => "IN_ACTIVE",
                "status" => "PROCESSING",
                "phone" => $addressUser['phone'],
                "customer_name" => $addressUser['name'],
                "full_address" => $fullAddress,
                "code" => $code,
                "discount_amount" => $request->discount_amount,
            ];
            $order = Order::create($dataOrder);

            $data = [];
            foreach ($productCarts as $key => $item) {
                $data[] = [
                    'order_id' => $order->id,
                    'product_variant_id' => $item['product_variant_id'],
                    'product_name' => $item['product_variant']['product']['name'],
                    'product_price' => $item['product_variant']['price'],
                    'quantity' => $item['quantity'],
                    'total_price' => $item['quantity'] * $item['product_variant']['price']
                ];
            }

            OrderItem::insert($data);

            // Xóa các sản phẩm trong giỏ hàng
            $dataCart = array_map(fn($value) => $value['id'], $productCarts);
            Cart::destroy($dataCart);

            if ($request->payment_method == 'momo') {
                $orderId = $order->id;
                $urlRedirect = route('order-success', $orderId);

                $url = $this->payMomo($dataOrder, $urlRedirect);
                // dd($url);
                if ($url) {
                    DB::commit();
                    return redirect()->to($url);
                } else {
                    throw new Exception("Error Payment", 1);
                }
            }

            if ($request->voucher_id && $request->id_voucherUsage) {
                $voucher = Voucher::find($request->voucher_id);
                $voucherUsage = VoucherUsage::find($request->id_voucherUsage);
                if ($voucher && $voucherUsage) {
                    // Giảm số lượng limit và tăng số lượng voucher_used
                    $voucher->update([
                        'limit' => $voucher->limit - 1,       // Giảm số lần có thể sử dụng
                        'voucher_used' => $voucher->voucher_used + 1, // Tăng số lần đã sử dụng
                    ]);

                    $voucherUsage->delete();
                }
            }

            //  giao dịch thành công
            DB::commit();


            // Thông báo thành công và chuyển hướng
            sweetalert("Đơn hàng đã được đặt!", NotificationInterface::SUCCESS, [
                'position' => "center",
                'timeOut' => '',
                'closeButton' => false
            ]);
            return redirect()->route("order-success", ['id' => $order->id]);
        } catch (\Exception $e) {
            // Hủy giao dịch khi có lỗi
            DB::rollBack();
            //            dd($e);

            // Ghi log lỗi hoặc thông báo lỗi (có thể sử dụng sweetalert để báo lỗi)
            sweetalert("Đã xảy ra lỗi khi đặt hàng!", NotificationInterface::ERROR, [
                'position' => "center",
                'timeOut' => '',
                'closeButton' => false
            ]);

            // Quay lại trang trước với thông báo lỗi
            return back()->withErrors(['error' => 'Đã xảy ra lỗi khi đặt hàng. Vui lòng thử lại sau!']);
        }
    }

    public function placeOrderBuyNow(CreateOrderBuyNow $request)
    {
        // dd($request->all());
        $userId = Auth::id();
        $variantId = $request->variant;
        $productVariant = ProductVariant::with('product')->where('id', $variantId)->first();
        try {
            DB::beginTransaction();
            $paymentMethod = null;
            if ($request->payment_method == 'momo' || $request->payment_method == 'vnpay') {
                $paymentMethod = "BANK_TRANSFER";
            } else {
                $paymentMethod = "CASH";
            }


            $quantity = $productVariant->quantity - $request->quantity;
            $sold = $productVariant->sold + $request->quantity;
            // Cập nhật lại số lượng trong bảng product_variants

            $productVariant->quantity = $quantity; // cap nhat lai so luong ton kho
            $productVariant->sold = $sold; // cap nhat so luong da ban
            $productVariant->save();
            // Kiểm tra kết quả sau khi cập nhật
            // $productCarts = $productCarts->toArray();

            // lay du lieu dia chi nguoi nhan
            $addressUser = AddressUser::with(['province', 'district', 'ward'])->where('id', $request->address_user_id)->first()->toArray();

            $fullAddress = $addressUser['address_detail'] . " - " . $addressUser['ward']['name']
                . " - " . $addressUser['district']['name'] . " - " . $addressUser['province']['name'];

            // ma don hang
            $code = $this->codeOrder();
            // dd($fullAddress);
            $dataOrder = [
                "user_id" => $userId,
                "total_amount" => $request->total_amount,
                "payment_method" => $paymentMethod,
                "note" => $request->note,
                "confirm_status" => "IN_ACTIVE",
                "status" => "PROCESSING",
                "phone" => $addressUser['phone'],
                "customer_name" => $addressUser['name'],
                "full_address" => $fullAddress,
                "code" => $code,
                "discount_amount" => $request->discount_amount,
            ];
            $order = Order::create($dataOrder);


            $data[] = [
                'order_id' => $order->id,
                'product_variant_id' => $productVariant['id'],
                'product_name' => $productVariant['product']['name'],
                'product_price' => $productVariant['price'],
                'quantity' => $request->quantity,
                'total_price' => $request->quantity * $productVariant['price']
            ];

            OrderItem::insert($data);


            if ($request->voucher_id && $request->id_voucherUsage) {
                $voucher = Voucher::find($request->voucher_id);
                $voucherUsage = VoucherUsage::find($request->id_voucherUsage);
                if ($voucher && $voucherUsage) {
                    // Giảm số lượng limit và tăng số lượng voucher_used
                    $voucher->update([
                        'limit' => $voucher->limit - 1,       // Giảm số lần có thể sử dụng
                        'voucher_used' => $voucher->voucher_used + 1, // Tăng số lần đã sử dụng
                    ]);

                    $voucherUsage->delete();
                }
            }

            //  giao dịch thành công
            DB::commit();
            if ($request->payment_method == 'momo') {
                $orderId = $order->id;
                $urlRedirect = route('order-success', $orderId);

                $url = $this->payMomo($dataOrder, $urlRedirect);
                // dd($url);
                if ($url) {
                    DB::commit();
                    return redirect()->to($url);
                } else {
                    throw new Exception("Error Payment", 1);
                }
            }


            // Thông báo thành công và chuyển hướng
            sweetalert("Đơn hàng đã được đặt!", NotificationInterface::SUCCESS, [
                'position' => "center",
                'timeOut' => '',
                'closeButton' => false
            ]);
            return redirect()->route("order-success", ['id' => $order->id]);
        } catch (\Exception $e) {
            // Hủy giao dịch khi có lỗi
            DB::rollBack();
            //            dd($e);

            // Ghi log lỗi hoặc thông báo lỗi (có thể sử dụng sweetalert để báo lỗi)
            sweetalert("Đã xảy ra lỗi khi đặt hàng!", NotificationInterface::ERROR, [
                'position' => "center",
                'timeOut' => '',
                'closeButton' => false
            ]);

            // Quay lại trang trước với thông báo lỗi
            return back()->withErrors(['error' => 'Đã xảy ra lỗi khi đặt hàng. Vui lòng thử lại sau!']);
        }
    }

    private function codeOrder()
    {
        // Tạo một chuỗi ngẫu nhiên gồm các chữ cái viết hoa và số với độ dài 14 ký tự
        // $code = Str::upper(Str::random(14));
        $time = now()->format('YmdHis');
        //        dd($time);

        // Đảm bảo chuỗi có cả số và chữ cái bằng cách trộn ký tự từ hai tập hợp riêng biệt
        $letters = Str::random(7); // Lấy 7 chữ cái ngẫu nhiên
        $numbers = substr(str_shuffle($time), 0, 7); // Lấy 4 số ngẫu nhiên

        // Gộp và xáo trộn chữ cái và số để đảm bảo vị trí ngẫu nhiên
        $mixedCode = str_shuffle($letters . $numbers);
        return strtoupper($mixedCode);
    }

    private function payMomo($dataOrder, $urlRedirect)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = env("MOMO_PARTNER_CODE");
        $accessKey = env("MOMO_ACCESS_KEY");
        $secretKey = env("MOMO_SECRET_KEY");
        $orderInfo = "Thanh toán MOMO"; // cai nay yeu cau khong duoc de trong
        $amount = $dataOrder['total_amount'];
        $orderId = $dataOrder['code'];
        $redirectUrl = $urlRedirect;
        $ipnUrl = $urlRedirect; // chuyen huong khi thanh cong
        $extraData = "";
        $requestId = $dataOrder['code'];
        $requestType = "payWithATM";

        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;

        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );

        $result = $this->execPostRequest($endpoint, json_encode($data));

        if (!$result) {
            // Nếu không có kết quả, API có thể đã gặp lỗi kết nối
            dd("Error: No response from MoMo API.");
        }


        $jsonResult = json_decode($result, true);
        if (isset($jsonResult['errorCode']) && $jsonResult['errorCode'] != 0) {
            // Nếu có lỗi, hiển thị mã lỗi
            dd("MoMo API error: " . $jsonResult['errorCode'] . " - " . $jsonResult['localMessage']);
        }

        // $jsonResult = json_decode($result, true);  // decode json

        //Just a example, please check more in there
        if (isset($jsonResult['payUrl'])) {
            return $jsonResult['payUrl'];
        } else {
            dd("Error: MoMo API did not return payUrl.", $jsonResult);
        }
        // header('Location: ' . $jsonResult['payUrl']);
    }
    private function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }
}
