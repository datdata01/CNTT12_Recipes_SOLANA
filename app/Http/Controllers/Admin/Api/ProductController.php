<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function filter(Request $request)
    {
        $category = $request->category;
        $search = $request->search;
        $status = $request->status;

        try {
            $query = Product::with(['productImages', 'categoryProduct', 'productVariants'])->latest('id');

            // Lọc theo danh mục
            if ($category && $category !== 'all') {
                $query->where('category_product_id', $category);
            }

            // Lọc theo trạng thái
            if ($status && $status !== 'all') {
                $query->where('status', $status);
            }

            // Tìm kiếm
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('code', 'like', '%' . $search . '%')
                        ->orWhere('name', 'like', '%' . $search . '%');
                });
            }

            // Phân trang
            $products = $query->paginate(5);

            if ($products->isEmpty()) {
                return response()->json([
                    'products' => [],
                    'pagination' => [
                        'prev_page_url' => null,
                        'next_page_url' => null,
                        'current_page' => 1,
                        'last_page' => 1,
                    ],
                    'message' => 'Không tìm thấy sản phẩm nào phù hợp.',
                ]);
            }

            return response()->json([
                'products' => $products,
                'pagination' => [
                    'prev_page_url' => $products->previousPageUrl(),
                    'next_page_url' => $products->nextPageUrl(),
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Có lỗi xảy ra: ' . $e->getMessage(),
            ], 500);
        }
    }
}
