<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Products\FilterProductRequest;
use App\Models\Attribute;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\AttributeValue;
use Illuminate\Support\Facades\DB;

class CollectionProductController extends Controller
{
    public function index($id = null)
    {
        // $products = Product::with(['productImages', 'categoryProduct', 'productVariants', 'favorites'])
        //     ->latest('id')
        //     ->paginate(20);

        $products = Product::leftJoin('product_variants as pv', 'products.id', '=', 'pv.product_id')
            ->leftJoin('order_items as ot', 'pv.id', '=', 'ot.product_variant_id')
            ->leftJoin('feedbacks as f', 'ot.id', '=', 'f.order_item_id')
            ->leftJoin('category_products as cp', 'cp.id', '=', 'products.category_product_id')
            ->select('products.*', DB::raw('COALESCE(AVG(f.rating), 0) as average_rating'))
            ->groupBy('products.id');
        if ($id != null) {
            $products = $products->where('cp.id', '=', $id);
        }
        $products = $products->latest('products.id')
            ->paginate(20);

        // dd($products);

        $categories = CategoryProduct::withCount('products')->get();
        $minPrice = ProductVariant::min('price') ?? 0;
        $maxPrice = ProductVariant::max('price') ?? 0;

        // Lấy thuộc tính cùng với các giá trị của chúng
        $attributes = Attribute::with('attributeValues')->get();

        return view('client.pages.collection-product.index', compact('products', 'categories', 'minPrice', 'maxPrice', 'attributes'));
    }
    public function filter(FilterProductRequest $request)
    {
        $categories = $request->input('categories');
        $attributes = $request->input('attributes');
        $minPrice = $request->input('minPrice');
        $maxPrice = $request->input('maxPrice');
        $sort = $request->input('sort'); // Nhận giá trị sắp xếp
        // Lọc sản phẩm
        $query = Product::leftJoin('product_variants as pv', 'products.id', '=', 'pv.product_id')
            ->leftJoin('order_items as ot', 'pv.id', '=', 'ot.product_variant_id')
            ->leftJoin('feedbacks as f', 'ot.id', '=', 'f.order_item_id')
            ->select('products.*', DB::raw('COALESCE(AVG(f.rating), 0) as average_rating'))
            ->groupBy('products.id');

        // $query = Product::with(['productImages', 'categoryProduct', 'productVariants.attributeValues']);

        if (!empty($categories)) {
            $query->whereIn('category_product_id', $categories);
        }

        if (!empty($attributes)) {
            $query->whereHas('productVariants.attributeValues', function ($q) use ($attributes) {
                $q->whereIn('attribute_value_id', $attributes);
            });
        }

        if (!is_null($minPrice) && !is_null($maxPrice)) {
            $query->whereHas('productVariants', function ($q) use ($minPrice, $maxPrice) {
                $q->whereBetween('price', [(float)$minPrice, (float)$maxPrice]);
            });
        }

        // Thêm logic sắp xếp
        switch ($sort) {
            case 'price_asc':
                $subQuery = DB::table('product_variants')
                    ->select('product_id', DB::raw('MIN(price) as min_price'))
                    ->groupBy('product_id');

                $query->joinSub($subQuery, 'prices', function ($join) {
                    $join->on('products.id', '=', 'prices.product_id');
                })
                    ->select('products.*')
                    ->orderBy('prices.min_price', 'ASC');
                break;

            case 'price_desc':
                $subQuery = DB::table('product_variants')
                    ->select('product_id', DB::raw('MAX(price) as max_price'))
                    ->groupBy('product_id');

                $query->joinSub($subQuery, 'prices', function ($join) {
                    $join->on('products.id', '=', 'prices.product_id');
                })
                    ->select('products.*')
                    ->orderBy('prices.max_price', 'DESC');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'created_at_desc':
                $query->select('products.*') // Đảm bảo chỉ lấy dữ liệu từ bảng products
                    ->orderBy('created_at', 'desc'); // Sắp xếp từ mới đến cũ
                break;

            case 'created_at_asc':
                $query->select('products.*') // Đảm bảo chỉ lấy dữ liệu từ bảng products
                    ->orderBy('created_at', 'asc'); // Sắp xếp từ cũ đến mới
                break;

            case 'best_selling':
                $query->join('product_variants', 'products.id', '=', 'product_variants.product_id')
                    ->select('products.*', DB::raw('SUM(product_variants.sold) as total_sold')) // Tính tổng số lượng đã bán
                    ->groupBy('products.id') // Nhóm theo ID sản phẩm
                    ->orderBy('total_sold', 'DESC'); // Sắp xếp theo tổng số lượng đã bán
                break;

            case 'least_selling':
                $subQuery = DB::table('product_variants')
                    ->select('product_id', DB::raw('SUM(sold) as total_sold')) // Tính tổng số lượng đã bán
                    ->groupBy('product_id'); // Nhóm theo ID sản phẩm

                $query->joinSub($subQuery, 'sold_counts', function ($join) {
                    $join->on('products.id', '=', 'sold_counts.product_id');
                })
                    ->select('products.*')
                    ->orderBy('sold_counts.total_sold', 'ASC'); // Sắp xếp theo tổng số lượng đã bán, bán ít nhất trước
                break;
            case 'rating_asc':
                $query->leftJoin('product_variants', 'product_variants.product_id', '=', 'products.id')
                    ->leftJoin('order_items', 'order_items.product_variant_id', '=', 'product_variants.id')
                    ->leftJoin('feedbacks', 'feedbacks.order_item_id', '=', 'order_items.id') // Nối feedbacks với order_items
                    ->select('products.*', DB::raw('COALESCE(AVG(feedbacks.rating), 0) as avg_rating')) // Thay NULL bằng 0
                    ->groupBy('products.id') // Nhóm theo id của sản phẩm
                    ->orderBy('avg_rating', 'ASC'); // Sắp xếp theo rating từ thấp đến cao
                break;
            case 'rating_desc':
                $query->leftJoin('product_variants', 'product_variants.product_id', '=', 'products.id')
                    ->leftJoin('order_items', 'order_items.product_variant_id', '=', 'product_variants.id')
                    ->leftJoin('feedbacks', 'feedbacks.order_item_id', '=', 'order_items.id') // Nối feedbacks với order_items
                    ->select('products.*', DB::raw('COALESCE(AVG(feedbacks.rating), 0) as avg_rating')) // Thay NULL bằng 0
                    ->groupBy('products.id') // Nhóm theo id của sản phẩm
                    ->orderBy('avg_rating', 'DESC'); // Sắp xếp theo rating từ thấp đến cao
                break;


            default:
                $query->latest('id'); // Sắp xếp mặc định theo ID mới nhất
                break;
        }

        $products = $query->get();

        // Render HTML của danh sách sản phẩm và đếm số lượng sản phẩm
        $view = view('client.pages.collection-product.list', compact('products'))->render();
        $count = $products->count();

        return response()->json([
            'html' => $view,
            'count' => $count > 0 ? $count : 0, // Trả về số lượng sản phẩm, hoặc 0 nếu không tìm thấy
            'message' => $count > 0 ? '' : 'Không có sản phẩm nào phù hợp với tiêu chí lọc.'
        ]);
    }
}
