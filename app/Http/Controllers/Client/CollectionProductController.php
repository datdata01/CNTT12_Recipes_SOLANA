<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Products\FilterProductRequest;
use App\Models\Attribute;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;

class CollectionProductController extends Controller
{
    public function index($id = null)
    {
        // Query sản phẩm
        $products = Product::query()
            ->leftJoin('product_variants as pv', 'products.id', '=', 'pv.product_id')
            ->leftJoin('order_items as ot', 'pv.id', '=', 'ot.product_variant_id')
            ->leftJoin('feedbacks as f', 'ot.id', '=', 'f.order_item_id')
            ->leftJoin('category_products as cp', 'cp.id', '=', 'products.category_product_id')
            ->select(
                'products.*',
                DB::raw('COALESCE(AVG(f.rating), 0) as average_rating'),
                DB::raw('SUM(pv.quantity) as total_stock') // Tổng số lượng tồn kho
            )
            ->groupBy('products.id');

        // Lọc theo danh mục nếu có
        if ($id !== null) {
            $products->where('cp.id', '=', $id);
        }

        // Sắp xếp mặc định theo ID mới nhất
        $products = $products->latest('products.id')->paginate(20);

        // Dữ liệu danh mục, giá, và thuộc tính
        $categories = CategoryProduct::withCount('products')->get();
        $minPrice = ProductVariant::min('price') ?? 0;
        $maxPrice = ProductVariant::max('price') ?? 0;
        $attributes = Attribute::with('attributeValues')->get();

        // Trả về view
        return view('client.pages.collection-product.index', compact('products', 'categories', 'minPrice', 'maxPrice', 'attributes'));
    }

    public function filter(FilterProductRequest $request)
    {
        $categories = $request->input('categories');
        $attributes = $request->input('attributes');
        $minPrice = $request->input('minPrice');
        $maxPrice = $request->input('maxPrice');
        $sort = $request->input('sort');
        $stockStatus = $request->input('stock_status');

        // Khởi tạo query cơ bản
        $query = Product::query()
            ->leftJoin('product_variants as pv', 'products.id', '=', 'pv.product_id')
            ->leftJoin('order_items as ot', 'pv.id', '=', 'ot.product_variant_id')
            ->leftJoin('feedbacks as f', 'ot.id', '=', 'f.order_item_id')
            ->select(
                'products.*',
                DB::raw('COALESCE(AVG(f.rating), 0) as average_rating'),
                DB::raw('SUM(pv.quantity) as total_stock') // Tổng số lượng tồn kho
            )
            ->groupBy('products.id');

        // Lọc theo danh mục
        if (!empty($categories)) {
            $query->whereIn('products.category_product_id', $categories);
        }

        // Lọc theo thuộc tính
        if (!empty($attributes)) {
            $query->whereHas('productVariants.attributeValues', function ($q) use ($attributes) {
                $q->whereIn('attribute_value_id', $attributes);
            });
        }

        // Lọc theo khoảng giá
        if (!is_null($minPrice) && !is_null($maxPrice)) {
            $query->whereHas('productVariants', function ($q) use ($minPrice, $maxPrice) {
                $q->whereBetween('price', [(float)$minPrice, (float)$maxPrice]);
            });
        }

        // Lọc theo trạng thái tồn kho
        if ($stockStatus === 'in_stock') {
            $query->having('total_stock', '>', 0);
        } elseif ($stockStatus === 'out_of_stock') {
            $query->having('total_stock', '=', 0);
        }

        // Xử lý sắp xếp
        $query = $this->applySorting($query, $sort);

        // Lấy danh sách sản phẩm
        $products = $query->paginate(12);

        // Render HTML danh sách sản phẩm
        $view = view('client.pages.collection-product.list', compact('products'))->render();
        $count = $products->total();

        // Trả về JSON
        return response()->json([
            'html' => $view,
            'count' => $count,
            'message' => $count > 0 ? '' : 'Không có sản phẩm nào phù hợp với tiêu chí lọc.',
        ]);
    }

    private function applySorting($query, $sort)
    {
        switch ($sort) {
            case 'price_asc':
                $subQuery = DB::table('product_variants')
                    ->select('product_id', DB::raw('MIN(price) as min_price'))
                    ->groupBy('product_id');

                $query->joinSub($subQuery, 'prices', function ($join) {
                    $join->on('products.id', '=', 'prices.product_id');
                })
                    ->orderBy('prices.min_price', 'ASC');
                break;

            case 'price_desc':
                $subQuery = DB::table('product_variants')
                    ->select('product_id', DB::raw('MAX(price) as max_price'))
                    ->groupBy('product_id');

                $query->joinSub($subQuery, 'prices', function ($join) {
                    $join->on('products.id', '=', 'prices.product_id');
                })
                    ->orderBy('prices.max_price', 'DESC');
                break;

            case 'name_asc':
                $query->orderBy('products.name', 'asc');
                break;

            case 'name_desc':
                $query->orderBy('products.name', 'desc');
                break;

            case 'created_at_desc':
                $query->orderBy('products.created_at', 'desc');
                break;

            case 'created_at_asc':
                $query->orderBy('products.created_at', 'asc');
                break;

                // case 'best_selling':
                //     $query->join('product_variants as pv', 'products.id', '=', 'pv.product_id')
                //         ->select(DB::raw('SUM(pv.sold) as total_sold'))
                //         ->groupBy('products.id')
                //         ->orderBy('total_sold', 'DESC');
                //     break;
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
                $query->orderBy('average_rating', 'ASC');
                break;

            case 'rating_desc':
                $query->orderBy('average_rating', 'DESC');
                break;

            default:
                $query->latest('products.id');
                break;
        }

        return $query;
    }
}
