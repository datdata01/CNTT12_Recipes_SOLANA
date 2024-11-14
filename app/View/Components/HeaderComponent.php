<?php

namespace App\View\Components;

use App\Models\Cart;
use App\Models\CategoryArticle;
use App\Models\CategoryProduct;
use App\Models\Favorite;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class HeaderComponent extends Component
{
    public $categoryProduct;
    public $categoryArticle;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->categoryProduct = CategoryProduct::all();
        $this->categoryArticle = CategoryArticle::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $cartResponse = 0;
        $love=0;
        if (Auth::check()) {
            $userId = Auth::id();
            $cartResponse = Cart::where('user_id', $userId)->count('*');
            $love = Favorite::where('user_id', $userId)->count('*');
        }

        // dd($this->categoryProduct);
        return view('client.layouts.partials.header.header-menu', [
            'categoryProduct' => $this->categoryProduct,
            'categoryArticle' => $this->categoryArticle,
            'numberCart' => $cartResponse,
            'love' => $love,

        ]);
    }
}
