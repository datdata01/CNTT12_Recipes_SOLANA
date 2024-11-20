<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\CategoryArticle;
use App\Models\CommentPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $articles = Article::orderBy('id', 'desc')->paginate(10); // Lấy danh sách bài viết
        $latestPosts = Article::orderBy('id', 'desc')->take(4)->get();
        $categories = CategoryArticle::withCount( 'articles')->get();
        return view('client.pages.blog.index', compact('articles', 'latestPosts', 'categories'));
    }

    public function articlesByCategory($id)
    {
        // Lấy thể loại theo id
        $category = CategoryArticle::findOrFail($id);

        // Lấy các bài viết thuộc thể loại đó
        $articles = $category->articles()->orderBy('id', 'desc')->paginate(3);

        // Lấy các bài viết mới nhất
        $latestPosts = Article::orderBy('id', 'desc')->take(4)->get();

        // Lấy danh sách thể loại để hiển thị bên sidebar
        $categories = CategoryArticle::withCount('articles')->get();

        // Trả về view với các dữ liệu tương ứng
        return view('client.pages.collection-blog.index', compact('articles', 'latestPosts', 'categories', 'category'));
    }
    // Trong Controller
public function showComments($articleId) {
    $comments = CommentPost::with('user', 'replies.user')->where('article_id', $articleId)->get();
    return view('client.pages.blog.comment_render', compact('comments'));
}

    public function show($id)
    {
        // Tìm bài viết theo ID
        $article = Article::findOrFail($id);

        // Lấy các bình luận cho bài viết, cùng với thông tin người dùng
        $comments = CommentPost::with(['user', 'replies.user'])
        ->where('article_id', $article->id)
        ->whereNull('parent_comment_id') // Chỉ lấy các comment chính (không có comment cha)
        ->get();


        // Lấy các bài viết mới nhất
        $latestPosts = Article::orderBy('id', 'desc')->take(4)->get();

        // Lấy danh sách các thể loại với số lượng bài viết
        $categories = CategoryArticle::withCount('articles')->get();

        // Truyền các biến sang view
        return view('client.pages.blog.index', compact('article', 'comments', 'latestPosts', 'categories'));
    }

    public function storeComment(Request $request, $articleId)
    {
        $request->validate([
            'comment' => 'required|string',
            'parent_comment_id' => 'nullable|integer', // Nếu có ID của bình luận cha
        ]);

        CommentPost::create([
            'article_id' => $articleId,
            'user_id' => auth()->id(),
            'parent_comment_id' => $request->input('parent_comment_id'), // Nếu có
            'comment' => $request->input('comment'),
        ]);

        return redirect()->route('blog.show', $articleId);
    }

}
