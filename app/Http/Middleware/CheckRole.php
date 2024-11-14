<?php

namespace App\Http\Middleware;

use Closure;
use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (Auth::check()) {
            $user = Auth::user();
            $roleIds = $this->getUserRoleIds($user->id);
            // Debugging: In ra thông tin để kiểm tra
            // dd('Current User ID: ' . $user->id, 'Role ID: ' . $roleId, 'Required Role: ' . $role);
            // So sánh roleId và role
            if (!in_array((int)$role, $roleIds)) {
                // Thông báo lỗi nếu không có quyền
                toastr("Tài khoản không đủ quyền truy cập", NotificationInterface::ERROR, "Cảnh báo", [
                    "closeButton" => true,
                    "progressBar" => true,
                    "timeOut" => "3000",
                ]);
                return redirect()->route('404');
            }
        }
        // Nếu quyền đúng, tiếp tục xử lý yêu cầu
        return $next($request);
    }

    /**
     * Lấy role_id của người dùng.
     *
     * @param  int  $userId
     * @return mixed
     */
    protected function getUserRoleIds($userId)
    {
        return \DB::table('user_roles')->where('user_id', $userId)->pluck('role_id')->toArray();
    }

}
