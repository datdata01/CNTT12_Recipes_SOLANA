<?php

namespace App\Http\Controllers\Client\Api;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function toggleFavorite(Request $request)
    {
        $user = $request->userId;
        $product = Product::find($request->product_id);
        // dd($user);
        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Sản phẩm không tồn tại'], 400);
        }
        $love = Favorite::where('user_id', $user)->count('*');
        $favorite = Favorite::where('user_id', $user)
            ->where('product_id', $product->id)
            ->first();
        if ($favorite && $favorite->delete()) {
            // Xóa sản phẩm khỏi yêu thích
            $love = Favorite::where('user_id', $user)->count('*');
            return response()->json([
                'status' => 'removed',
                'love' => $love
            ]);
        } else {
            // Thêm sản phẩm vào yêu thích
            Favorite::create([
                'user_id' => $user,
                'product_id' => $product->id
            ]);

            $product->increment('love', 1);
            $love = Favorite::where('user_id', $user)->count('*');
            return response()->json([
                'status' => 'added',
                'love' => $love
            ]);
        }
    }
    public function removeFavorite(Request $request)
    {
        // Tìm sản phẩm yêu thích từ database
        $wishListItem = Favorite::find($request->favorite_id);
        $user = $request->userId;
        if ($wishListItem) {
            // Xóa sản phẩm khỏi danh sách yêu thích
            $wishListItem->delete();
            $love = Favorite::where('user_id', $user)->count('*');
            return response()->json(['status' => 'removed', 'message' => 'Sản phẩm đã được xóa khỏi yêu thích','love'=> $love]);
        }

        return response()->json(['status' => 'error', 'message' => 'Không tìm thấy sản phẩm yêu thích'],400);
    }
}

