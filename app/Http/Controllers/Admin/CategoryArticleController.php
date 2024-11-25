<?php

namespace App\Http\Controllers\Admin;


use Flasher\Prime\Notification\NotificationInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\categoryArticle\CreateCategoryArticleRequest;
use App\Http\Requests\Admin\categoryArticle\UpdateCategoriArticleRequest;
use App\Models\CategoryArticle;

class CategoryArticleController extends Controller
{
    public function index()
    {
        $categories = CategoryArticle::query()
            ->orderBy("id", "desc")
            ->paginate(12);
        return view("admin.pages.category.articles.index", ['listCategoryArticle' => $categories]);
    }

    public function store(CreateCategoryArticleRequest $request)
    {
        $validatedData = $request->validated();
        $cate = new CategoryArticle();
        $cate->create($validatedData);
        toastr("Thêm mới thành công", NotificationInterface::SUCCESS, "Thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return redirect()->route("category-article.index");
    }
    public function show(string $id)
    {
    }
    public function edit(string $id)
    {
        $cate = CategoryArticle::find($id);
        return view("admin.pages.category.articles.update", ["category" => $cate]);
    }
    public function update(UpdateCategoriArticleRequest $request, string $id)
    {
        $validatedData = $request->validated();
        $cate = CategoryArticle::find($id);
        $cate->update($validatedData);
        toastr("Cập nhập thành công", NotificationInterface::SUCCESS, "Thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return redirect()->route("category-article.index");
    }
    public function destroy(string $id)
    {
        try {
            $cate = CategoryArticle::findOrFail($id); // Sử dụng findOrFail để ném ngoại lệ nếu không tìm thấy danh mục
            // Kiểm tra xem danh mục có bài viết liên kết hay không
            if ($cate->articles()->count() > 0) { // Giả sử có một mối quan hệ 'articles' trong model CategoryArticle
                toastr("Không thể xóa danh mục này vì nó có bài viết liên kết.", NotificationInterface::ERROR, "Lỗi", [
                    "closeButton" => true,
                    "progressBar" => true,
                    "timeOut" => "3000",
                ]);
                return redirect()->route("category-article.index");
            }

            $cate->delete();
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

        return redirect()->route("category-article.index");
    }

}
