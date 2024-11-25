<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Banner;
use App\Models\CategoryProduct;
use App\Models\Feedback;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::join('product_variants as pv', 'products.id', '=', 'pv.product_id')
            ->leftJoin('order_items as ot', 'pv.id', '=', 'ot.product_variant_id') // Để lấy cả sản phẩm không có order
            ->leftJoin('feedbacks as f', 'ot.id', '=', 'f.order_item_id') // Để lấy cả sản phẩm không có đánh giá
            ->select(
                'products.*',
                DB::raw('COALESCE(AVG(f.rating), 0) as average_rating') // Thay null bằng 0 nếu không có đánh giá
            )
            ->groupBy('products.id')
            ->orderBy('love', 'desc') // Sắp xếp theo yêu thích
            ->orderByDesc('products.created_at') // Thêm sắp xếp theo ngày tạo để ưu tiên sản phẩm mới
            ->take(4) // Lấy 4 sản phẩm
            ->get();

        // dd($products->toArray());

        $averageRatings = Product::join('product_variants as pv', 'products.id', '=', 'pv.product_id')
            ->join('order_items as ot', 'pv.id', '=', 'ot.product_variant_id')
            ->join('feedbacks as f', 'ot.id', '=', 'f.order_item_id')
            ->select('products.*', DB::raw('AVG(f.rating) as average_rating'))
            ->groupBy('products.id')
            ->orderBy('average_rating', 'desc')
            ->get();

        $newProducts = Product::leftJoin('product_variants as pv', 'products.id', '=', 'pv.product_id')
            ->leftJoin('order_items as ot', 'pv.id', '=', 'ot.product_variant_id')
            ->leftJoin('feedbacks as f', 'ot.id', '=', 'f.order_item_id')
            ->select('products.*', DB::raw('AVG(f.rating) as average_rating'))
            ->groupBy('products.id')
            ->latest()
            ->take(4)
            ->get();

        $productNew = Product::join('product_variants as pv', 'products.id', '=', 'pv.product_id')
            ->leftJoin('order_items as ot', 'pv.id', '=', 'ot.product_variant_id')
            ->leftJoin('feedbacks as f', 'ot.id', '=', 'f.order_item_id')
            ->select('products.*', DB::raw('AVG(f.rating) as average_rating'))
            ->groupBy('products.id')
            ->latest()
            ->get();

        $bestSellingProducts = Product::join('product_variants as pv', 'products.id', '=', 'pv.product_id')
            ->leftJoin('order_items as ot', 'pv.id', '=', 'ot.product_variant_id') // Đảm bảo lấy cả sản phẩm không có đơn hàng
            ->leftJoin('feedbacks as f', 'ot.id', '=', 'f.order_item_id') // Đảm bảo lấy cả sản phẩm không có đánh giá
            ->select(
                'products.*',
                DB::raw('COALESCE(AVG(f.rating), 0) as average_rating'), // Thay null bằng 0 nếu không có đánh giá
                DB::raw('COALESCE(SUM(pv.sold), 0) as total_sold') // Thay null bằng 0 nếu không có sản phẩm bán
            )
            ->groupBy('products.id')
            ->orderBy('total_sold', 'desc') // Sắp xếp theo tổng số lượng bán được
            ->take(4) // Lấy 4 sản phẩm
            ->get();


        $blogArticles = Article::latest()->take(5)->get();

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
            'productNew',
            'bestSellingProducts',
            'averageRatings',
            'blogArticles',
        ));
    }
    public function loadAllCollection() {}
}
