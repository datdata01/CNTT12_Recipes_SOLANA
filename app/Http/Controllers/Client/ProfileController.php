<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Feedback\EditFeedbackRequest;
use App\Http\Requests\Client\Feedback\FeedbackRequest;
use App\Http\Requests\Client\profiles\EditProfileRequest;
use App\Models\District;
use App\Models\Feedback;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Province;
use App\Models\User;
use App\Models\Voucher;
use App\Models\VoucherUsage;
use App\Models\Ward;
use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function infomation()
    {
        return view('client.pages.profile.information');
    }

    public function orderHistory()
    {
        $userId = Auth::id();
        // Lấy tất cả các Order cùng với OrderItems và ProductVariants
        $orders = Order::with('orderItems.productVariant.attributeValues.attribute', 'orderItems.productVariant.product', 'user')
            ->where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->get();
        return view('client.pages.profile.order', compact('orders'));
    }
    public function feedbackstore(FeedbackRequest $request)
    {
        // Tạo mới feedback
        $feedback = new Feedback();
        $feedback->order_item_id = $request->input('order_item_id');
        $feedback->user_id = $request->input('user_id');
        $feedback->rating = $request->input('rating');
        $feedback->comment = $request->input('comment');
        $feedback->updated_at = NULL;

        // Xử lý file tải lên (nếu có)
        if ($request->hasFile('file_path')) {
            $feedback->file_path = $request->file('file_path')->store('feedbacks'); // Lưu tệp vào thư mục feedbacks
        } else {
            $feedback->file_path = null; // Thiết lập giá trị là null nếu không có tệp
        }

        // Lưu feedback vào cơ sở dữ liệu
        $feedback->save();

        $voucher = Voucher::where('type', 'SUCCESS')->first();

        if ($voucher) {
            $startDate = Carbon::now()->lt($voucher->start_date) ? $voucher->start_date : Carbon::now();

            $data = [
                "user_id" => Auth::id(),
                "voucher_id" => $voucher->id,
                "vourcher_code" => strtoupper(string: Str::random(8)),
                "start_date" => $startDate,
                "end_date" => $voucher->end_date,
                "status" => "ACTIVE",
            ];

            VoucherUsage::create($data);
        }

        // Thông báo cho người dùng
        sweetalert("Cảm ơn bạn đã đánh giá sản phẩm ", NotificationInterface::INFO, [
            'position' => "center",
            'timeOut' => '',
            'closeButton' => false,
            'icon' => "success",
        ]);

        return back();
    }
    public function orderDetail($id)
    {
        // Lấy thông tin đơn hàng theo ID
        $order = Order::with('orderItems.productVariant.product', 'refund')->findOrFail($id);
        return view('client.pages.profile.layouts.components.details', compact('order'));
    }
    public function orderCancel(Request $request, $id)
    {
        // Lấy thông tin đơn hàng từ ID
        $order = Order::findOrFail($id);
        // Lấy thông tin người dùng đang đăng nhập
        $user = Auth::user();

        // Kiểm tra xem lý do có được chọn hay không
        if (empty($request->cancel_reason)) {
            sweetalert("Vui lòng chọn lý do hủy đơn hàng.", NotificationInterface::ERROR, [
                'position' => "center",
                'timeOut' => '',
                'closeButton' => false,
                'icon' => "error", // Thông báo lỗi
            ]);
            return back();
        }

        // Nếu lý do là "Khác", kiểm tra xem người dùng có nhập lý do không
        if ($request->cancel_reason === 'other' && empty($request->cancel_reason_other)) {
            sweetalert("Vui lòng nhập lý do khác.", NotificationInterface::ERROR, [
                'position' => "center",
                'timeOut' => '',
                'closeButton' => false,
                'icon' => "error", // Thông báo lỗi
            ]);
            return back();
        }

        // Kiểm tra trạng thái của đơn hàng có cho phép hủy không
        if ($order->status === 'PENDING') {
            // Lưu lý do hủy vào cột cancel_reason hoặc cancel_reason_other
            if ($request->cancel_reason === 'other') {
                $order->cancel_reason = $request->cancel_reason;
                $order->cancel_reason_other = $request->cancel_reason_other; // Lưu lý do nhập tay
            } else {
                $order->cancel_reason = $request->cancel_reason; // Lưu lý do chọn từ danh sách
            }

            // Cập nhật trạng thái đơn hàng thành 'CANCELED'
            $order->status = 'CANCELED'; // Đảm bảo cập nhật trạng thái đơn hàng
            $order->save(); // Lưu thay đổi
            // dd($order->toArray());
            // Tăng giá trị cancel_count của người dùng (nếu cần)
            // $user->increment('cancel_count', 1);

            // Thông báo hủy đơn thành công
            sweetalert("Đơn hàng của bạn đã được hủy.", NotificationInterface::INFO, [
                'position' => "center",
                'timeOut' => '',
                'closeButton' => false,
                'icon' => "success", // Thông báo thành công
            ]);

            // Quay lại trang trước
            return redirect()->back();
        }

        // Thông báo nếu không thể hủy đơn hàng
        sweetalert("Đơn hàng không thể hủy vì trạng thái không hợp lệ.", NotificationInterface::ERROR, [
            'position' => "center",
            'timeOut' => '',
            'closeButton' => false,
            'icon' => "error", // Thông báo lỗi
        ]);

        return redirect()->back();
    }
        public function orderDelete($id)
    {
        $order = Order::findOrFail($id);
        $user = Auth::user();

        // Xóa order và orderItems liên quan
        $order->orderItems()->delete();
        $order->delete();

        // Tăng giá trị cancel_count
        $user->increment('cancel_count', 1);

        // Kiểm tra ngưỡng cancel_count
        $response = $this->handleCancelThreshold($user);
        if ($response) {
            return $response; // Điều hướng nếu tài khoản bị vô hiệu hóa
        }

        sweetalert("Đơn của bạn đã được xóa", NotificationInterface::INFO, [
            'position' => "center",
            'timeOut' => '',
            'closeButton' => false,
            'icon' => "success",
        ]);

        return redirect()->route('profile.order-history');
    }

    private function handleCancelThreshold($user)
    {
        if ($user->cancel_count == 3) {
            sweetalert("Bạn đã hủy đơn hàng quá nhiều lần! Hãy cẩn thận với lần tiếp theo.", NotificationInterface::WARNING, [
                'position' => "center",
                'timeOut' => '',
                'closeButton' => false,
                'icon' => "warning",
            ]);
        }

        if ($user->cancel_count >= 5) {
            // Chuyển trạng thái của người dùng thành IN_ACTIVE
            $user->status = 'IN_ACTIVE';
            $user->save();

            sweetalert("Tài khoản của bạn đã bị vô hiệu hóa do hủy quá nhiều đơn hàng.", NotificationInterface::ERROR, [
                'position' => "center",
                'timeOut' => '',
                'closeButton' => false,
                'icon' => "error",
            ]);

            // Đăng xuất người dùng sau khi vô hiệu hóa
            Auth::logout();
            return redirect()->route('auth.login-view');
        }
    }

    public function confirmstatus($id)
    {
        $order = Order::findOrFail($id);
        $user = Auth::user();
        $order->status = 'COMPLETED';
        $order->confirm_status = 'ACTIVE';
        $order->save();
        $user->cancel_count = 0;
        $user->save();
        sweetalert("Cảm ơn bạn đã xác nhận", NotificationInterface::INFO, [
            'position' => "center",
            'timeOut' => '',
            'closeButton' => false,
            'icon' => "success",
        ]);
        return redirect()->back();
    }

    public function address()
    {
        $user_id = User::where('user_id')->get();
        $provinces = Province::all();
        $districts = District::where('province_id')->get();
        $wards = Ward::where('district_id')->get();

        return view('client.pages.profile.address', compact('provinces', 'districts', 'wards', 'user_id'));
    }
    public function editProfile(EditProfileRequest $request)
    {
        $id = Auth::user()->id; // Lấy id tài khoản đang đăng nhập
        $user = User::find($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = Storage::put('users', $request->file('image'));
        }

        $imagePath = $user->image;

        $user->update($data);

        if (
            $request->hasFile('image')
            && !empty($imagePath)
            && Storage::exists($imagePath)
        ) {
            Storage::delete($imagePath);
        }
        toastr("Cập nhật thông tin hồ sơ thành công", NotificationInterface::SUCCESS, "Thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
            "color" => "red"
        ]);
        return back();
    }
}
