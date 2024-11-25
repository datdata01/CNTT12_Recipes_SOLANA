<?php

namespace App\Http\Controllers\Client\Api;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\VoucherUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
    // Kiểm tra mã giảm giá đã được sử dụng chưa
    public function checkVoucher(Request $request)
    {
        // Kiểm tra mã giảm giá có tồn tại trong cơ sở dữ liệu
        $voucher = Voucher::where('code', $request->coupon_code)->first();

        if (!$voucher) {
            return response()->json(['status' => 'invalid', 'message' => 'Mã giảm giá không hợp lệ.'], 400);
        }

        // Kiểm tra ngày bắt đầu và ngày kết thúc
        $currentDate = now();

        // Kiểm tra trạng thái của mã giảm giá
        if ($voucher->status !== 'ACTIVE' || $currentDate < $voucher->start_date || $currentDate > $voucher->end_date) {
            return response()->json(['status' => 'inactive', 'message' => 'Mã giảm giá không khả dụng.'], 400);
        }

        // Kiểm tra nếu mã giảm giá đã được sử dụng bởi user
        $voucherUsage = VoucherUsage::where('voucher_id', $voucher->id)
            ->where('user_id', $request->user_id)
            ->first();

        // Nếu voucher có giới hạn sử dụng, kiểm tra xem đã hết lượt sử dụng chưa
        if ($voucher->limited_uses && optional($voucherUsage)->used >= $voucher->limited_uses) {
            return response()->json(['status' => 'used_up', 'message' => 'Mã giảm giá này đã hết lượt sử dụng.'], 400);
        }

        // Nếu voucherUsage chưa tồn tại, tạo mới
        if (!$voucherUsage) {
            $voucherUsage = VoucherUsage::create([
                'user_id' => $request->user_id,
                'voucher_id' => $voucher->id,
            ]);
        }

        // Trả về thông tin voucher và voucherUsage
        return response()->json([
            'status' => 'valid',
            'data' => $voucher, // Thông tin giảm giá
            'usage' => $voucherUsage, // Trả về voucherUsage, bao gồm cả ID
        ]);
    }


}
