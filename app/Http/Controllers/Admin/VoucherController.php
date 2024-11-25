<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Http\Requests\Admin\voucher\CreateVoucherRequest;
use App\Http\Requests\Admin\voucher\UpdateVoucherRequest;
use App\Models\VoucherUsage;
use Flasher\Prime\Notification\NotificationInterface;
use Carbon\Carbon;

class VoucherController extends Controller
{
    public function index()
    {
        $getAllVoucher = Voucher::latest('id')->paginate(10);
        return view('admin.pages.voucher.index', compact('getAllVoucher'));
    }

    public function create()
    {
        return view('admin.pages.voucher.create');
    }

    public function store(CreateVoucherRequest $request)
    {
        // check trùng voucher (1 voucher k thể xuất hiện 2 lần)
        $existingVoucher = Voucher::where([
            ['name', $request->name],
            ['code', $request->code],
            ['description', $request->description],
            ['limit', $request->limit],
            ['start_date', $request->start_date],
            ['end_date', $request->end_date],
            ['discount_type', $request->discount_type],
            ['discount_value', $request->discount_value],
            ['min_order_value', $request->min_order_value],
            ['max_order_value', $request->max_order_value],
            ['status', $request->status],
        ])->first();

        if ($existingVoucher) {
            toastr("Voucher này đã tồn tại", NotificationInterface::WARNING, "Cảnh báo!", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
            return back()->withInput();
        }
        if ($request->discount_type == 'PERCENTAGE' && $request->discount_value > 100) {
            return back()->withErrors(['discount_value' => 'Giá trị giảm theo phần trăm không được lớn hơn 100.'])->withInput();
        }

        Voucher::create([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'limit' => $request->limit,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'min_order_value' => $request->min_order_value,
            'max_order_value' => $request->max_order_value,
            'status' => $request->status,
            'type' => $request->type,
        ]);

        toastr("Thêm thành công dữ liệu voucher", NotificationInterface::SUCCESS, "Thành công !", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return back();
    }

    public function show(string $id) {}

    public function edit(string $id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('admin.pages.voucher.edit', compact('voucher'));
    }

    public function update(UpdateVoucherRequest $request, string $id)
    {
        $voucher = Voucher::findOrFail($id);

        if ($request->discount_type == 'PERCENTAGE' && $request->discount_value > 100) {
            return back()->withErrors(['discount_value' => 'Giá trị giảm theo phần trăm không được lớn hơn 100.'])->withInput();
        }

        $dataUpdate = [
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'limit' => $request->limit,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'min_order_value' => $request->min_order_value,
            'max_order_value' => $request->max_order_value,
            'status' => $request->status,
            'type' => $request->type,
        ];

        $updateSuccess = $voucher->update($dataUpdate);

        if ($updateSuccess) {
            toastr("Cập nhật thành công voucher !", NotificationInterface::SUCCESS, "Thành công !", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
            return redirect()->route('voucher.index');
        }
        toastr("Cập nhật không thành công !", NotificationInterface::ERROR, "Thất bại !", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return redirect()->back();
    }

    public function destroy($id)
    {
        // Tìm voucher
        $voucher = Voucher::find($id);

        if (!$voucher) {
            toastr("Voucher không tồn tại!", NotificationInterface::ERROR, "Thất bại!", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
            return redirect()->route('voucher.index');
        }

        // Kiểm tra xem voucher có bản ghi liên quan trong voucher_usages không
        $hasUsages = VoucherUsage::where('voucher_id', $id)->exists();

        if ($hasUsages) {
            // Nếu có liên quan, đổi trạng thái về IN_ACTIVE
            $voucher->status = 'IN_ACTIVE';
            $voucher->save();

            toastr("Vô hiệu hóa Voucher thành công!", NotificationInterface::SUCCESS, "Thành công!", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
        } else {
            // Nếu không liên quan, cho phép xóa
            $voucher->delete();

            toastr("Xóa voucher thành công!", NotificationInterface::SUCCESS, "Thành công!", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
        }

        return redirect()->route('voucher.index');
    }
}
