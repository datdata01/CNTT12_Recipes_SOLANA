<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // App\Http\Controllers\Admin\Api\UserController.php

    public function filter(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        try {
            $query = User::with('roles')->latest('id');  // Sử dụng 'roles' thay vì 'role'

            // Tìm kiếm theo tên hoặc email
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('full_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('email', 'LIKE', '%' . $search . '%');
                });
            }

            // Lọc theo trạng thái
            if ($status && $status !== 'all') {
                $query->where('status', $status);
            }

            // Phân trang
            $users = $query->paginate(5);

            return response()->json([
                'users' => $users,
                'pagination' => [
                    'prev_page_url' => $users->previousPageUrl(),
                    'next_page_url' => $users->nextPageUrl(),
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                ],
                'message' => 'Không tìm thấy tài khoản.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Có lỗi xảy ra: ' . $e->getMessage(),
            ], 500);
        }
    }
}
