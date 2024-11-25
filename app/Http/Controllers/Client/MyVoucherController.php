<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\VoucherUsage;
use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MyVoucherController extends Controller
{
    public function index()
    {
        $data = VoucherUsage::with('voucher')
            ->where('user_id', Auth::id())
            // ->Where('end_date', '>', Carbon::now())
            ->latest('id')
            ->get();
        // dd($data->toArray());
        return view('client.pages.profile.voucher', compact('data'));
    }
    public function create(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:255',
        ]);

        // Kiểm tra mã giảm giá
        $voucher = Voucher::where('code', $data['code'])->first();

        if (!$voucher) {
            toastr('Mã giảm giá không tồn tại!', NotificationInterface::WARNING, 'CẢNH BÁO', [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
            return redirect()->back();
        }

        // Kiểm tra xem tài khoản đã sử dụng mã này chưa
        $existingUsage = VoucherUsage::where('user_id', Auth::id())
            ->where('voucher_id', $voucher->id)
            ->first();

        if ($existingUsage) {
            toastr('Mã đã tồi tại', NotificationInterface::WARNING, 'CẢNH BÁO', [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
            return redirect()->back();
        }

        // Nếu chưa sử dụng, tạo bản ghi mới
        VoucherUsage::create([
            "user_id"    => Auth::id(),
            "voucher_id" => $voucher->id,
        ]);

        toastr('Voucher đã được áp dụng thành công!', NotificationInterface::SUCCESS, 'THÀNH CÔNG', [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);

        return redirect()->back();
    }

}
