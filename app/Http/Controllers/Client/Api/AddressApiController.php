<?php

namespace App\Http\Controllers\Client\Api;

use App\Http\Controllers\Controller;
use App\Models\AddressUser;
use App\Models\District;
use App\Models\Ward;
use Illuminate\Http\Request;

class AddressApiController extends Controller
{
    // Lấy quận/huyện dựa trên tỉnh
    public function getDistricts($province_id)
    {
        $districts = District::where('province_id', $province_id)->get();
        return response()->json($districts);
    }

    // Lấy phường/xã dựa trên quận/huyện
    public function getWards($district_id)
    {
        $wards = Ward::where('district_id', $district_id)->get();
        return response()->json($wards);
    }

    public function setDefaultAddress(Request $request, $id)
    {
        // Lấy user_id từ request không Auth:: được vì gọi Api 
        $userId = $request->input('user_id');

        // Kiểm tra xem user_id có hợp lệ không
        if (!$userId) {
            return response()->json(['status' => 'error', 'message' => 'Người dùng chưa đăng nhập'], 401);
        }

        // Đặt tất cả các địa chỉ của người dùng thành default = 0
        AddressUser::where('user_id', $userId)->update(['default' => 0]);

        // Tìm địa chỉ được chọn để đặt default thành 1
        $address = AddressUser::where('id', $id)->where('user_id', $userId)->first();

        // Kiểm tra nếu địa chỉ tồn tại và thuộc về người dùng hiện tại
        if ($address) {
            $address->default = 1;
            $address->save();

            return response()->json(['status' => 'success', 'message' => 'Cập nhật địa chỉ mặc định thành công']);
        }

        return response()->json(['status' => 'error', 'message' => 'Không tìm thấy địa chỉ hoặc địa chỉ không thuộc về người dùng'], 404);
    }
}
