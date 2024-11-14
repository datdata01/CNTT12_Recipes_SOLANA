<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Order;
use Carbon\Carbon;

class UpdateOrderStatus
{
    public function handle($request, Closure $next)
    {
        $threeDaysAgo = Carbon::now()->subDays(3);

        // Cập nhật các đơn hàng mà confirm_status là 'IN_ACTIVE' và status là 'SHIPPED'
        Order::where('confirm_status', 'IN_ACTIVE')
            ->where('status', 'SHIPPED')
            ->where('updated_at', '<=', $threeDaysAgo)
            ->update(['status' => 'COMPLETED', 'confirm_status' => 'ACTIVE']);

        return $next($request);
    }
}

