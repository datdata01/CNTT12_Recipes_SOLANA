<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\products\StoreProductRequest;
use App\Http\Requests\Admin\products\UpdateProductRequest;
use App\Models\Attribute;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\ProductVariant;
use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::with(['productImages', 'categoryProduct', 'productVariants'])
            ->latest('id')->paginate(5);
        $categories = CategoryProduct::get();
        // dd($data->toArray());
        return view('admin.pages.products.index', compact('data','categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $attributes = Attribute::with('attributeValues')->get();
        $categoryProduct = CategoryProduct::pluck('name', 'id')->all();

        return view('admin.pages.products.create', compact('attributes', 'categoryProduct'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $product = Product::create([
                    'name' => $request->name,
                    'code' => $request->code,
                    'description' => $request->description,
                    'category_product_id' => $request->category_product_id,
                    'status' => $request->status,
                    'image' => $request->hasFile('image') ? Storage::put('products/images', $request->file('image')) : null,
                ]);

                // Xử lý album ảnh (nếu có)
                if ($request->hasFile('image_url')) {
                    foreach ($request->file('image_url') as $image) {
                        $imagePath = Storage::put('products/albums', $image);
                        $product->productImages()->create(['image_url' => $imagePath]);
                    }
                }

                // Kiểm tra và lưu các biến thể của sản phẩm
                if (isset($request->variants) && is_array($request->variants) && count($request->variants) > 0) {
                    foreach ($request->variants as $variantData) {
                        // Tạo biến thể sản phẩm
                        $variant = ProductVariant::create([
                            'product_id' => $product->id,
                            'price' => $variantData['price'],
                            'quantity' => $variantData['quantity'],
                        ]);

                        // Gắn các giá trị thuộc tính vào biến thể (nếu có)
                        if (isset($variantData['attributes']) && is_array($variantData['attributes'])) {
                            foreach ($variantData['attributes'] as $attributeValueId) {
                                $variant->attributeValues()->attach($attributeValueId);
                            }
                        }
                    }
                } else {
                    // Ném ngoại lệ nếu không có biến thể nào được tạo
                    throw new \Exception('Vui lòng tạo ít nhất một biến thể cho sản phẩm.');
                }
            });

            // Hiện thông báo thành công
            toastr("Sản phẩm đã được thêm mới thành công!", NotificationInterface::SUCCESS, "Thành công", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
                "color" => "red"
            ]);

            return redirect()->route('products.index');
        } catch (\Throwable $th) {
            // Hiện thông báo lỗi với thông báo từ ngoại lệ
            toastr("Đã có lỗi xảy ra: " . $th->getMessage(), NotificationInterface::ERROR, "Thất bại", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
                "color" => "red"
            ]);

            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with(['productImages', 'categoryProduct', 'productVariants.attributeValues.attribute'])->findOrFail($id);

        if ($product) {
            echo "Tên sản phẩm: " . $product->name . "<br><br>";

            // Tạo mảng để lưu trữ các thuộc tính và giá trị của chúng
            $attributes = [];

            // Lặp qua tất cả các biến thể của sản phẩm
            foreach ($product->productVariants as $variant) {
                // Lặp qua các giá trị thuộc tính của biến thể
                foreach ($variant->attributeValues as $attributeValue) {
                    // Thêm thuộc tính và giá trị của nó vào mảng
                    $attributes[$attributeValue->attribute->id]['name'] = $attributeValue->attribute->name;
                    $attributes[$attributeValue->attribute->id]['values'][$attributeValue->id] = $attributeValue->name;
                }
            }

            // Hiển thị các thuộc tính và các giá trị
            foreach ($attributes as $attributeId => $attribute) {
                echo "Thuộc tính: " . $attribute['name'] . "<br>";

                foreach ($attribute['values'] as $valueId => $valueName) {
                    echo '<input type="radio" name="attribute_values[' . $attributeId . ']" value="' . $valueName . '">';
                    echo  $valueName . "<br>";
                }

                echo "<br>";
            }
        } else {
            echo "Không có biến thể nào.";
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // dd($product->toArray());
        $attributes = Attribute::with('attributeValues')->get(); // Lấy các thuộc tính và giá trị
        $categoryProduct = CategoryProduct::pluck('name', 'id'); // Pluck sẽ trả về collection, không cần `all()`

        return view('admin.pages.products.edit', compact('attributes', 'categoryProduct', 'product'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {

        // dd($request->all());
        try {
            DB::transaction(function () use ($request, $product) {
                // 1. Cập nhật ảnh sản phẩm
                if ($request->hasFile('image')) {
                    // Xóa ảnh cũ nếu có
                    if ($product->image) {
                        Storage::delete($product->image);
                    }
                    // Lưu ảnh mới
                    $product->image = $request->file('image')->store('products/images');
                }

                // 2. Cập nhật thông tin sản phẩm
                $product->update([
                    'name' => $request->name,
                    'code' => $request->code,
                    'description' => $request->description,
                    'category_product_id' => $request->category_product_id,
                    'status' => $request->status,
                ]);

                // 3. Cập nhật album ảnh
                if ($request->hasFile('image_url')) {
                    // Xóa các ảnh cũ
                    foreach ($product->productImages as $productImage) {
                        Storage::delete($productImage->image_url);
                        $productImage->delete(); // Xóa bản ghi trong DB
                    }

                    // Lưu ảnh mới vào album
                    foreach ($request->file('image_url') as $image) {
                        $imagePath = $image->store('products/albums');
                        $product->productImages()->create(['image_url' => $imagePath]);
                    }
                }

                // 4. Xoá các biến thể không cần thiết
                if ($request->has('delete_variants')) {
                    // In ra giá trị delete_variants để kiểm tra
                    ProductVariant::whereIn('id', $request->delete_variants)->delete();
                }
    
                

                // 5. Cập nhật hoặc tạo mới các biến thể sản phẩm còn tồn tại
                if ($request->has('variants')) {
                    foreach ($request->variants as $variantData) {
                        // Kiểm tra nếu biến thể đã bị xóa thì bỏ qua
                        if (in_array($variantData['id'] ?? null, $request->delete_variants ?? [])) {
                            continue;
                        }

                        // Kiểm tra nếu không có 'id' trong $variantData
                        if (!isset($variantData['id'])) {
                            // Xử lý trường hợp không có 'id' (có thể tạo mới)
                            $variant = ProductVariant::create([
                                'product_id' => $product->id,
                                'price' => $variantData['price'],
                                'quantity' => $variantData['quantity'],
                            ]);

                            // Cập nhật thuộc tính biến thể
                            if (isset($variantData['attributes'])) {
                                $variant->attributeValues()->sync($variantData['attributes']);
                            }
                        } else {
                            // Tiến hành cập nhật biến thể nếu 'id' tồn tại
                            $variant = ProductVariant::updateOrCreate(
                                ['id' => $variantData['id'], 'product_id' => $product->id],
                                [
                                    'price' => $variantData['price'],
                                    'quantity' => $variantData['quantity'],
                                ]
                            );

                            // Cập nhật thuộc tính biến thể
                            if (isset($variantData['attributes'])) {
                                $variant->attributeValues()->sync($variantData['attributes']);
                            }
                        }
                    }
                }
            });

            toastr("Sản phẩm đã được cập nhật thành công!", NotificationInterface::SUCCESS, "Thành công", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
                "color" => "red"
            ]);

            return redirect()->back();
        } catch (\Throwable $e) {
            toastr("Đã có lỗi xảy ra trong quá trình cập nhật sản phẩm.", NotificationInterface::ERROR, "Thất bại", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
                "color" => "red"
            ]);
            return redirect()->back();
        }
    }




    /**
     * Remove the specified resource from storage.
     */
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            // Xóa ảnh chính của sản phẩm (nếu có)
            if ($product->image) {
                Storage::delete($product->image);
            }

            // Xóa các ảnh album liên quan
            foreach ($product->productImages as $productImage) {
                Storage::delete($productImage->image_url); // Xóa ảnh album khỏi storage
                $productImage->delete(); // Xóa bản ghi trong DB
            }

            // Xóa các biến thể sản phẩm (product variants)
            foreach ($product->productVariants as $variant) {
                // Xóa các giá trị thuộc tính (attribute values) liên quan đến biến thể
                $variant->attributeValues()->detach();
                $variant->delete();
            }

            // xóa sản phẩm
            $product->delete();

            toastr("Sản phẩm đã được xóa thành công!", NotificationInterface::SUCCESS, "Thành công", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
                "color" => "red"
            ]);
        } catch (\Throwable $th) {
            toastr("Sản phẩm đã được xóa không thành công!", NotificationInterface::ERROR, "Thất bại", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
                "color" => "red"
            ]);
        }

        return redirect()->back();
    }
}
