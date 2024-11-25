<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Product;
use Flasher\Prime\Notification\NotificationInterface;
// use Flasher\Laravel\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index($id)
    {
        $product = Product::with(['productImages', 'productVariants.attributeValues.attribute', 'categoryProduct'])->findOrFail($id);
        // dd($product);
        if ($product) {
            // Tăng view mỗi khi sản phẩm được xem
            $product->increment('view');
        }
        $productVariants = $product->toArray()['product_variants'];
        $variantResponse = [];
        $productResponse = [];

        $productAttribute = []; // danh sach bien the tra ra


        // lay danh sach attribute
        foreach ($productVariants as $key1 => $variant) {
            // lay attribute
            foreach ($variant['attribute_values'] as $key2 => $value2) {
                $productAttribute[$key2]['id'] = $value2['attribute']['id'];
                $productAttribute[$key2]['name'] = $value2['attribute']['name'];
            }
        }
        // dd($productAttribute);

        // lay danh sach gia tri cua bien the
        foreach ($productAttribute as $key1 => $attribute) {
            $attributeValue = [];
            foreach ($productVariants as $key => $variant) {
                foreach ($variant['attribute_values'] as $key2 => $value) {
                    // dd($value);
                    if ($value['attribute_id'] == $attribute['id']) {
                        $attributeValue[] = [
                            'id' => $value['id'],
                            'name' => $value['name']
                        ];
                    }
                }
            }
            // dd($attributeValue);
            // loai bo nhung phan tu trung nhau
            $uniqueData = collect($attributeValue)->unique('id')->values()->toArray();
            // dd($uniqueData);
            $productAttribute[$key1]['value'] = $uniqueData;
        }

        // dd($productAttribute);
        // dd($product->toArray());

        // dd($productVariants);

        // lấy id danh mục sản phẩm , hiển thị sản phẩm cùng loại
        // hieen thị danh sách sản phẩm cùng loại với sản phẩm trước đó
        $categoryId = $product['category_product_id'];

        $relatedProducts = Product::join('product_variants as pv', 'products.id', '=', 'pv.product_id')
            ->leftJoin('order_items as ot', 'pv.id', '=', 'ot.product_variant_id')
            ->leftJoin('feedbacks as f', 'ot.id', '=', 'f.order_item_id')
            ->select('products.*', DB::raw('AVG(f.rating) as average_rating'))
            ->groupBy('products.id') // Nhóm đầy đủ các cột
            ->where('products.category_product_id', $categoryId) // Lọc cùng danh mục
            ->where('products.id', '!=', $id) // Loại trừ sản phẩm hiện tại
            ->orderBy('products.created_at', 'desc') // Sắp xếp từ mới đến cũ
            ->get();


        $feedbacks = Feedback::with(['orderItem.productVariant.product', 'user', 'replies'])
            ->whereHas('orderItem.productVariant.product', function ($query) use ($id) {
                $query->where('id', $id)->whereNull('parent_feedback_id');
            })
            ->orderBy('created_at', 'DESC')
            ->get();
        // dd($feedbacks);


        $feedbackCount = $feedbacks->count();

        // tính giá trị đánh giá trung bình của sản phẩm trả về giá trị làm tròn (1.0)
        $averageRating = $feedbacks->avg('rating');
        $averageRating = round($averageRating, 1);


        // Khởi tạo mảng để lưu tỷ lệ phần trăm cho từng mức sao
        $ratingProgress = [
            5 => 0,
            4 => 0,
            3 => 0,
            2 => 0,
            1 => 0,
        ];

        // Đếm số lượng phản hồi cho mỗi mức sao
        foreach ($feedbacks as $feedback) {
            $ratingProgress[$feedback->rating]++;
        }

        // Tính tỷ lệ phần trăm cho mỗi mức sao
        foreach ($ratingProgress as $rating => $count) {
            $ratingProgress[$rating] = $feedbackCount > 0 ? round(($count / $feedbackCount) * 100) : 0;
        }

        // dd($product->toArray());
        $productVariantJson = json_encode($productVariants);

        return view(
            'client.pages.product.index',
            compact('product', 'relatedProducts', 'productAttribute', 'productVariantJson', 'feedbacks', 'averageRating', 'feedbackCount', 'ratingProgress')
        );
    }


    public function replyFeedback(Request $request)
    {
        // Kiểm tra nếu người dùng có vai trò "admin"
        // $isAdmin = DB::table('user_roles')
        //     ->where('user_id', auth()->id())
        //     ->where('role_id', 2)  // 2 là ID vai trò của admin
        //     ->exists();

        // if (!$isAdmin) {
        //     return back()->with('error', 'Bạn không có quyền phản hồi đánh giá này.');
        // }


        $feedback = Feedback::create([
            'parent_feedback_id' => $request->parent_feedback_id,
            'user_id' => $request->user_id,
            'order_item_id' => $request->order_item_id,
            'comment' => $request->comment,
        ]);


        if ($feedback) {
            toastr("Phản hồi khách hàng thành công", NotificationInterface::SUCCESS, "Thành công !", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
        } else {
            toastr("Xóa phản hồi không thành công!", NotificationInterface::ERROR, "Thất bại!", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
        }

        return back();
    }
}
