<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flasher\Prime\Notification\NotificationInterface;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (Auth::check()) {
            $user = Auth::user();

            // Chuyển chuỗi vai trò phân tách bởi dấu '|' thành mảng
            $rolesArray = explode('|', $roles);

            // Kiểm tra người dùng có vai trò trong mảng $roles không
            if (!$user->hasAnyRole($rolesArray)) {
                // Thông báo lỗi nếu không có quyền
                toastr('Tài khoản không đủ quyền truy cập', NotificationInterface::ERROR,'Cảnh báo', [
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
}
