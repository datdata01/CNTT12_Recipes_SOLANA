<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;
use Flasher\Prime\Notification\NotificationInterface;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        // Xử lý lỗi 404
        if ($exception instanceof NotFoundHttpException) {
            Log::info('404 Exception triggered');

            if ($request->is('admin/*')) {
                Log::info('404 Admin View Triggered');
                toastr('Sai đường dẫn mất rồi', NotificationInterface::ERROR,'Cảnh báo', [
                    "closeButton" => true,
                    "progressBar" => true,
                    "timeOut" => "3000",
                ]);
                return response()->view('errors.404', [], 404);
            } else {
                Log::info('404 Client View Triggered');
                toastr('Sai đường dẫn mất rồi', NotificationInterface::ERROR,'Cảnh báo', [
                    "closeButton" => true,
                    "progressBar" => true,
                    "timeOut" => "3000",
                ]);
                return response()->view('errors.404-client', [], 404);
            }
        }

        // Xử lý lỗi 403
        if ($exception instanceof HttpException && $exception->getStatusCode() === 403) {
            Log::warning('403 Unauthorized Access triggered');

            // Kiểm tra nếu yêu cầu từ admin
            if ($request->is('admin/*')) {
                toastr('Tài khoản không đủ quyền truy cập', NotificationInterface::ERROR,'Cảnh báo', [
                    "closeButton" => true,
                    "progressBar" => true,
                    "timeOut" => "3000",
                ]);
                return redirect('/admin');
            }

            // Chuyển hướng về trang chủ cho người dùng thông thường
            return redirect('/')
                ->with('error', 'Bạn không có quyền truy cập.');
        }

        return parent::render($request, $exception);
    }
}
