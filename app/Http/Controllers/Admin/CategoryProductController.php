<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\categoryProduct\CreateCategoryProductRequest;
use App\Http\Requests\Admin\categoryProduct\UpdateCategoriProductRequest;
use App\Models\CategoryProduct;
use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Support\Facades\Storage;

class CategoryProductController extends Controller
{
    public function index()
    {
        $categories = CategoryProduct::orderBy("id", "desc")->paginate(12);
        return view("admin.pages.category.products.index", ['listCateProduct' => $categories]);
    }
    public function store(CreateCategoryProductRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['image'] = $request->file('image')->store('images/category', 'public') ?? null;
        CategoryProduct::create($validatedData);
        toastr("Thêm mới thành công", NotificationInterface::SUCCESS, "Thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return redirect()->route('category-product.index');
    }
    public function edit(string $id)
    {
        $category = CategoryProduct::findOrFail($id);
        return view('admin.pages.category.products.update', ['category' => $category]);
    }
    public function update(UpdateCategoriProductRequest $request, string $id)
    {
        $validatedData = $request->validated();
        $category = CategoryProduct::findOrFail($id);
        $validatedData['image'] = $request->hasFile('image') ? tap($request->file('image')->store('images/category', 'public'), function () use ($category) {
            Storage::disk('public')->delete($category->image);
        }) : $category->image;
        $category->update($validatedData);
        toastr("Cập nhập thành công", NotificationInterface::SUCCESS, "Thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return redirect()->route('category-product.index');
    }
    public function destroy(string $id)
    {
        try {
            $category = CategoryProduct::findOrFail($id); // Sử dụng findOrFail để ném ngoại lệ nếu không tìm thấy danh mục
            // Kiểm tra xem danh mục có sản phẩm liên kết hay không
            if ($category->products()->count() > 0) { // Giả sử có một mối quan hệ 'products' trong model CategoryProduct
                toastr("Không thể xóa danh mục này vì nó có sản phẩm liên kết.", NotificationInterface::ERROR, "Lỗi", [
                    "closeButton" => true,
                    "progressBar" => true,
                    "timeOut" => "3000",
                ]);
                return redirect()->back();
            }

            // Xóa ảnh liên quan từ storage
            Storage::disk('public')->delete($category->image);

            // Xóa danh mục
            $category->delete();

            toastr("Xóa thành công", NotificationInterface::SUCCESS, "Thành công", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
        } catch (\Exception $e) {
            // Bắt lỗi nếu có ngoại lệ
            toastr("Đã xảy ra lỗi: " . $e->getMessage(), NotificationInterface::ERROR, "Lỗi", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
            ]);
        }

        return redirect()->back();
    }
}
