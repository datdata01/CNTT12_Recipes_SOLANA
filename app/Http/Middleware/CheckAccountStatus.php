<?php

namespace App\Http\Middleware;

use Closure;
use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAccountStatus
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            // Kiểm tra trạng thái tài khoản
            if ($user->status !== 'ACTIVE') {
                // Lưu thông báo vào session
                toastr("Tài khoản đã bị khóa.", NotificationInterface::ERROR, "Cảnh báo", [
                    "closeButton" => true,
                    "progressBar" => true,
                    "timeOut" => "3000",
                ]);
                Auth::logout();
                return redirect()->route('auth.login-view');
            }
        }
        return $next($request);
    }
}
