<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\article\CreateArticleRequest;
use App\Http\Requests\Admin\article\UpdateArticleRequest;
use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\CategoryArticle;
use App\Models\Article;
use App\Models\ImageArticle;

class ArticleController extends Controller
{
    public function index()
    {
        $article = Article::with('categoryArticle')
            ->orderBy('id', 'desc')
            ->paginate(12);
        return view("admin.pages.article.index", ['listArticle' => $article]);
    }

    public function create()
    {
        $listImageArticle = ImageArticle::orderBy('id', 'desc')->get();
        $categories = CategoryArticle::all();

        return view('admin.pages.article.create', compact('categories', 'listImageArticle'));
    }

    public function store(CreateArticleRequest $request)
    {
        $path = $request->file('image') ? $request->file('image')->store('images/article', 'public') : null;

        $data = [
            'category_article_id' => $request->category_article_id,
            'title' => $request->title,
            'image' => $path,
            'content' => $request->content,
        ];

        Article::create($data);
        toastr("Chúc mừng bạn đã thêm thành công", NotificationInterface::SUCCESS, "Thêm thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return redirect()->route("article.create");
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $listImageArticle = ImageArticle::orderBy('id', 'desc')->get();
        $article = Article::findOrFail($id);
        // Lấy danh sách danh mục
        $categories = CategoryArticle::all();
        return view("admin.pages.article.update", compact('article', 'categories', 'listImageArticle'));
    }

    public function update(UpdateArticleRequest $request, $id)
    {
        $article = Article::findOrFail($id);

        $path = $article->image;

        $validatedData['image'] = $request->hasFile('image')
            ? tap($request->file('image')->store('images/category', 'public'), function () use ($article) {
                // Xóa hình ảnh cũ nếu tồn tại
                if ($article->image && Storage::disk('public')->exists($article->image)) {
                    Storage::disk('public')->delete($article->image);
                }
            })
            : $path;

        $data = [
            'category_article_id' => $request->category_article_id,
            'title' => $request->title,
            'image' => $validatedData['image'], // Lưu ảnh mới hoặc giữ ảnh cũ
            'content' => $request->content,
        ];

        $article->update($data);

        toastr("Chúc mừng bạn đã cập nhật thành công", NotificationInterface::SUCCESS, "Cập nhật thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);

        return redirect()->route("article.index");
    }



    public function destroy(string $id)
    {
        $article = Article::find($id);
        Storage::disk('public')->delete($article->image);
        $article->delete();
        toastr("Chúc mừng bạn đã xóa thành công", NotificationInterface::SUCCESS, "Xóa thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);
        return redirect()->route("article.index");
    }
}
