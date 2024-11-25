<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function filter(Request $request)
    {
        $status = $request->status;
        $search = $request->search;

        try {
            $query = Order::with('user')->latest('id');

            // Áp dụng bộ lọc trạng thái nếu có
            if ($status !== 'all') {
                $query->where('status', $status);
            }

            // Áp dụng tìm kiếm nếu có
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('code', 'like', '%' . $search . '%')
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('full_name', 'like', '%' . $search . '%');
                        });
                });
            }

            $orders = $query->paginate(5);

            return response()->json([
                'orders' => $orders,
                'pagination' => [
                    'prev_page_url' => $orders->previousPageUrl(),
                    'next_page_url' => $orders->nextPageUrl(),
                    'current_page' => $orders->currentPage(),
                    'last_page' => $orders->lastPage(),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
}
