<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    public function index()
    {
        // Lấy các sản phẩm yêu thích của người dùng hiện tại
        $favorites = Auth::user()->favorites()->with('product')->orderBy('created_at', 'desc')->paginate(10);
        // dd($favorites);
        // Trả về view với dữ liệu là các sản phẩm yêu thích của người dùng
        return view('client.pages.wish-list.index', compact('favorites'));
    }

    public function toggleFavorite(Request $request)
    {
        $user = Auth::user();
        $product = Product::find($request->product_id);

        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Sản phẩm không tồn tại']);
        }

        $favorite = Favorite::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($favorite) {
            // Xóa sản phẩm khỏi yêu thích
            $favorite->delete();
            return response()->json(['status' => 'removed']);
        } else {
            // Thêm sản phẩm vào yêu thích
            Favorite::create([
                'user_id' => $user->id,
                'product_id' => $product->id
            ]);
            $product->increment('love', 1);
            return response()->json(['status' => 'added']);
        }
    }
}
