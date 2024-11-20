<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\AddressUser\AddressUserRequest;
use App\Models\AddressUser;
use App\Models\District;
use App\Models\Province;
use App\Models\Ward;
use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddersController extends Controller
{
    // Hiển thị tất cả địa chỉ của người dùng hiện tại
    public function index()
    {
        $addressUsers = AddressUser::where('user_id', Auth::id())->get();
        $provinces = Province::all();
        return view('client.pages.profile.address', compact('provinces', 'addressUsers'));
    }


    // Thêm mới địa chỉ
    public function store(AddressUserRequest $request)
    {
        // $validated = $request->validated();

        // Nếu địa chỉ mới là mặc định, cập nhật các địa chỉ khác
        // if ($request->default) {
        //     AddressUser::where('user_id', Auth::id())->update(['default' => false]);
        // }
        if ($request->default) {
            AddressUser::where('user_id', Auth::id())->update(['default' => false]);
        }
        AddressUser::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'province_id' => $request->province_id,
            'district_id' => $request->district_id,
            'ward_id' => $request->ward_id,
            'address_detail' => $request->address_detail,
            'default' => $request->default ?? false,
        ]);
        toastr("Thêm địa chỉ thành công", NotificationInterface::SUCCESS, "Thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
            "color" => "red"
        ]);
        return back();
    }

    // Chỉnh sửa địa chỉ
    // public function edit($id)
    // {
    //     $address = AddressUser::findOrFail($id);
    //     $provinces = Province::all();
    //     return view('client.pages.profile.edit-address', compact('address', 'provinces'));
    // }

    // Cập nhật địa chỉ
    public function update(AddressUserRequest $request, $id)
    {
        // Xác thực dữ liệu đầu vào
        $validated = $request->validated();

        // Tìm địa chỉ thuộc về người dùng hiện tại
        $address = AddressUser::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Nếu địa chỉ cập nhật là mặc định, hủy mặc định các địa chỉ khác
        if ($request->default) {
            AddressUser::where('user_id', Auth::id())->update(['default' => false]);
        }

        // Cập nhật địa chỉ
        $address->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'province_id' => $request->province_id,
            'district_id' => $request->district_id,
            'ward_id' => $request->ward_id,
            'address_detail' => $request->address_detail,
            'default' => $request->default ?? false,
        ]);
        toastr("Cập nhật địa chỉ thành công", NotificationInterface::SUCCESS, "Thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
            "color" => "red"
        ]);
        // Chuyển hướng sau khi cập nhật thành công
        return redirect()->route('profile.address');
    }


    // Xóa địa chỉ
    public function destroy($id)
    {
        $address = AddressUser::findOrFail($id);
        $address->delete();
        toastr("Xóa thành công", NotificationInterface::SUCCESS, "Thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
            "color" => "red"
        ]);
        return redirect()->route('profile.address');
    }
}
