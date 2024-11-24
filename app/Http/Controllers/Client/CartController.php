<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $productCarts = Cart::with(['productVariant.product', 'productVariant.attributeValues.attribute'])->where('user_id', $userId)->get()->toArray();
        // dd($productCarts);
        $productResponse = [];
        foreach ($productCarts as $key => $value) {
            $productResponse[$key] = [];
            foreach ($productCarts as $key => $productCart) {
                $productResponse[$key]['cart'] = $productCart;
                $productResponse[$key]['product_variant'] = $productCart['product_variant'];
                $productResponse[$key]['product'] = $productCart['product_variant']['product'];
            }
        }

        // dd($productResponse);
        return view('client.pages.cart.index', [
            'productResponse' => $productResponse
        ]);
    }
}
