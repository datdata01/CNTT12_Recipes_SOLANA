<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Banner;
use App\Models\CategoryProduct;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with(['productImages', 'productVariants', 'categoryProduct'])
            ->orderBy('love', 'desc') // Sắp xếp theo trường love
            ->take(5)
            ->get();

        $newProducts = Product::with(['productImages', 'productVariants'])
            ->latest() // Sắp xếp theo thứ tự mới nhất
            ->take(4)
            ->get();

        $bestSellingProducts = Product::with(['productImages', 'productVariants'])
            ->withSum('productVariants as total_sold', 'sold') // Tính tổng sold
            ->orderBy('total_sold', 'desc') // Sắp xếp từ lớn đến bé
            ->take(4)
            ->get();

        // $articles = Article::latest()->take(4)->get();  // Lấy 4 bài viết mới nhất
        // dd($articles);

        // Lấy theo phân loại banner
        $headerBanners = Banner::where('image_type', 'HEADER')->latest()->first();
        $contentLeftTopBanners = Banner::where('image_type', 'CONTENT-LEFT-TOP')->latest()->first();
        $contentLeftBelowBanners = Banner::where('image_type', 'CONTENT-LEFT-BELOW')->latest()->first();
        $contentRightBanners = Banner::where('image_type', 'CONTENT-RIGHT')->latest()->first();
        $subscribeNowEmailBanners = Banner::where('image_type', 'SUBSCRIBE-NOW-EMAIL')->latest()->first();
        $leftBanners = Banner::where('image_type', 'BANNER-LEFT')->latest()->first();
        $rightBanners = Banner::where('image_type', 'BANNER-RIGHT')->latest()->first();

        $categoryProduct = CategoryProduct::all();

        return view('client.pages.home.index', compact(
            'products',
            'headerBanners',
            'contentLeftTopBanners',
            'contentLeftBelowBanners',
            'contentRightBanners',
            'subscribeNowEmailBanners',
            'leftBanners',
            'rightBanners',
            'categoryProduct',
            'newProducts',
            'bestSellingProducts',
        ));
    }
    public function loadAllCollection() {}
}
