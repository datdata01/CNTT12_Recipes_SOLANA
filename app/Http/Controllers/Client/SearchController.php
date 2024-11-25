<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; // Model Product để truy vấn sản phẩm

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $searchText = $request->input('text');

        $products = Product::with(['productVariants', 'categoryProduct'])
            ->where(function ($query) use ($searchText) {
                $query->where('name', 'LIKE', "%$searchText%")  // Tìm kiếm theo tên sản phẩm
                    ->orWhere('code', 'LIKE', "%$searchText%"); // Tìm kiếm theo mã sản phẩm
            })
            ->orWhereHas('categoryProduct', function ($query) use ($searchText) {
                $query->where('name', 'LIKE', "%$searchText%");  // Tìm kiếm theo tên danh mục
            })
            ->get();

        return response()->json($products);
    }
}
