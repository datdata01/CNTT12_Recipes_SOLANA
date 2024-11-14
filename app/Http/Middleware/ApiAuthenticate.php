<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ApiAuthenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Nếu yêu cầu là API, trả về JSON thông báo lỗi
        if ($request->expectsJson()) {
            return null; // Tránh redirect mà trả về JSON từ hàm handle
        }

        // Nếu không phải API, chuyển hướng đến trang đăng nhập
        return route('auth.login-view');
    }

    /**
     * Handle unauthenticated requests by returning a JSON response.
     */
    protected function unauthenticated($request, array $guards)
    {
        // Kiểm tra nếu là yêu cầu từ API thì trả về JSON thông báo lỗi
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Vui lòng đăng nhập.',
                'status' => 'warning',
                'title' => 'Cảnh báo'
            ], 401);
        }

        parent::unauthenticated($request, $guards);
    }
}
