<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Product;
use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // // Tính tổng số feedback
        // $totalFeedback = Feedback::whereNull('parent_feedback_id')->count();

        // // Tính tổng số sản phẩm
        // $totalProducts = Product::count(); // Hoặc dùng các điều kiện khác nếu cần

        // // Tính tỷ lệ feedback trên sản phẩm
        // $feedbackPerProduct = $totalProducts > 0 ? $totalFeedback / $totalProducts : 0;


        $feedbacks = Feedback::with(['orderItem.productVariant.attributeValues.attribute', 'orderItem.productVariant.product', 'user', 'replies'])
            ->whereNull('parent_feedback_id')
            ->paginate(10);

        $feedbackCount = $feedbacks->count();

        // Khởi tạo mảng để lưu tỷ lệ phần trăm cho từng mức sao
        $ratingProgress = [
            5 => 0,
            4 => 0,
            3 => 0,
            2 => 0,
            1 => 0,
        ];

        // Đếm số lượng phản hồi cho mỗi mức sao
        foreach ($feedbacks as $feedback) {
            $ratingProgress[$feedback->rating]++;
        }

        // Tính tỷ lệ phần trăm cho mỗi mức sao
        foreach ($ratingProgress as $rating => $count) {
            $ratingProgress[$rating] = $feedbackCount > 0 ? round(($count / $feedbackCount) * 100) : 0;
        }

        return view('admin.pages.feedback.index', compact('feedbacks', 'ratingProgress'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {

        $feedback = Feedback::create([
            'parent_feedback_id' => $request->parent_feedback_id,
            'user_id' => $request->user_id,
            'order_item_id' => $request->order_item_id,
            'comment' => $request->comment,
        ]);


        if ($feedback) {
            toastr("Phản hồi khách hàng thành công", NotificationInterface::SUCCESS, "Thành công !", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
        } else {
            toastr("Xóa phản hồi không thành công!", NotificationInterface::ERROR, "Thất bại!", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
        }

        return back();
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id) {}


    public function update(Request $request, string $id)
    {
        // Tìm feedback theo ID
        $feedback = Feedback::findOrFail($id);

        // Cập nhật feedback 
        $isUpdated = $feedback->update([
            'comment' => $request->comment
        ]);

        // Kiểm tra xem có được cập nhật không.
        if ($isUpdated) {
            toastr("Sửa phản hồi thành công!", NotificationInterface::SUCCESS, "Thành công!", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
        } else {
            toastr("Sửa phản hồi không thành công!", NotificationInterface::ERROR, "Thất bại!", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
        }

        return back();
    }


    public function destroy($id)
    {
        $feedback = Feedback::find($id); // Tìm feedback theo ID
        if (!$feedback) {
            toastr("Phản hồi không tồn tại!", NotificationInterface::ERROR, "Lỗi!", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
            return back();
        }

        // Xóa feedback
        $feedbackDestroy = $feedback->delete(); // Sử dụng phương thức delete() 
        if ($feedbackDestroy) {
            toastr("Xóa phản hồi thành công!", NotificationInterface::SUCCESS, "Thành công!", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
            return back();
        }

        toastr("Xóa phản hồi không thành công!", NotificationInterface::ERROR, "Thất bại!", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return back();
    }
}
