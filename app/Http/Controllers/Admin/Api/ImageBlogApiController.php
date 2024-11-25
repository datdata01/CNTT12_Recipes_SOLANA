<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ImageArticle\CreateImageArticleRequest;
use App\Models\ImageArticle;

class ImageBlogApiController extends Controller
{
    public function store(CreateImageArticleRequest $request)
    {

        // dd($request->all());

        // Kiểm tra xem có hình ảnh nào được tải lên không
        if ($request->hasFile('images')) {
            $imagePaths = [];
            $errors = []; // Mảng để lưu trữ thông báo lỗi

            // Lưu tất cả các hình ảnh vào thư mục và lấy đường dẫn
            foreach ($request->file('images') as $image) {
                try {
                    $path = $image->store('images/imagearticle', 'public');
                    $imagePaths[] = $path;

                    // Lưu vào cơ sở dữ liệu
                    ImageArticle::create(['image_url' => $path]);
                } catch (\Exception $e) {
                    // Nếu có lỗi trong quá trình lưu ảnh, thêm thông báo lỗi vào mảng
                    $errors[] = 'Không thể tải ảnh: ' . $e->getMessage();
                }
            }

            // Lấy danh sách hình ảnh vừa được thêm
            $listImageArticle = ImageArticle::latest('id')->get();

            // Nếu không có lỗi, trả về phản hồi thành công
            if (empty($errors)) {
                return response()->json([
                    'success' => true,
                    'images' => $listImageArticle,
                ]);
            } else {
                // Nếu có lỗi, trả về phản hồi với thông báo lỗi
                return response()->json([
                    'success' => false,
                    'errors' => $errors,
                    'images' => $listImageArticle, // Vẫn trả về danh sách hình ảnh đã thêm được
                ], 400);
            }
        }

        // Trả về phản hồi JSON với thông báo lỗi nếu không có hình ảnh nào được tải lên
        return response()->json(['success' => false, 'message' => 'Không có ảnh nào được tải lên'], 400);
    }
}
