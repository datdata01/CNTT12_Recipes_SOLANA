<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ImageArticle\CreateImageArticleRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\ImageArticle;
use App\Http\Controllers\Controller;
use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Validator;

class ImageArticleController extends Controller
{
    public function index()
    {
        $imageArticle = ImageArticle::latest('id')->paginate(5);
        return view('admin.pages.imagearticle.index', ['listImageArticle' => $imageArticle]);
    }

    public function create()
    {
        return view('admin.pages.imagearticle.create');
    }

    public function store(Request $request)
    {
        // Validate dữ liệu
        $validator = Validator::make($request->all(), [
            'images' => 'required', // Kiểm tra nếu có trường images
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Xác thực từng file ảnh
        ], [
            'images.required' => 'Vui lòng chọn một hình ảnh',
            'images.*.image' => 'Tệp tải lên phải là hình ảnh',
            'images.*.mimes' => 'Định dạng ảnh phải là jpeg, png, jpg, gif, svg',
            'images.*.max' => 'Kích thước ảnh phải nhỏ hơn 2MB',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();

            // Kiểm tra nếu $errors có thông tin lỗi
            if ($errors->isNotEmpty()) {
                return response()->json([
                    'success' => false,
                    'errors' => $errors->all(), // Lấy tất cả lỗi cho cả `images` và `images.*`
                ], 422);
            }
        }
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

    public function show($id)
    {
        $imageArticle = ImageArticle::findOrFail($id);
        return view('admin.pages.imagearticle.show', compact('imageArticle'));
    }

    public function destroy(string $id)
    {
        $imageArticle = ImageArticle::findOrFail($id); // Dùng findOrFail để tự động xử lý lỗi nếu không tìm thấy
        Storage::disk('public')->delete($imageArticle->image_url); // Xóa file trên disk
        $imageArticle->delete(); // Xóa bản ghi trong database

        toastr("Chúc mừng bạn đã xóa thành công", NotificationInterface::SUCCESS, "Xóa thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);

        return redirect()->route("imagearticle.index");
    }
}
