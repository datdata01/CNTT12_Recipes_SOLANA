<?php

namespace App\Http\Middleware;

use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        toastr("Vui lòng đăng nhập.", NotificationInterface::WARNING, "Cảnh báo", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return $request->expectsJson() ? null : route('auth.login-view');
    }
}
