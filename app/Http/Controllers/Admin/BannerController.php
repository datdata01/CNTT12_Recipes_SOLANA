<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\banner\BannerRequest;
use App\Http\Requests\Admin\banner\BannerRequest2;
use App\Models\Banner;
use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    // Danh sách tất cả các banners
    public function index()
    {
        $banners = Banner::latest('id')->paginate(12);
        return view('admin.pages.banner.index', compact('banners'));
    }


    // Hiển thị form tạo mới banner
    public function create()
    {
        return view('admin.pages.banner.create');
    }

    // Lưu banner mới vào database
    public function store(BannerRequest $request) // Use BannerRequest
    {
        $validated = $request->validated();

        // Handle the image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('banner', 'public');
            $validated['image_url'] = $path;
        }

        // Create the banner record
        Banner::create($validated);
        toastr("Thêm thành công", NotificationInterface::SUCCESS, "Thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
            "color" => "red"
        ]);

        return redirect()->route('banner.create');
    }

    // Hiển thị chi tiết banner
    public function show($id)
    {
        $banners = Banner::findOrFail($id);
        return view('admin.pages.banner.show', compact('banners'));
    }

    // Hiển thị form chỉnh sửa banner
    public function edit($id)
    {
        $banners = Banner::findOrFail($id);
        return view('admin.pages.banner.edit', compact('banners'));
    }

    // Cập nhật banner
    public function update(BannerRequest2 $request, $id) 
    {
       
        $validated = $request->validated();

        $banners = Banner::findOrFail($id);

        // Kiểm tra xem có upload file ảnh mới không
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($banners->image_url && Storage::exists($banners->image_url)) {
                Storage::delete($banners->image_url);
            }

            // Lưu ảnh mới
            $path = $request->file('image')->store('banner', 'public');
            $validated['image_url'] = $path;
        }

        // Update the banner with the validated data
        $banners->update($validated);
        toastr("Cập nhật thành công", NotificationInterface::SUCCESS, "Thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
            "color" => "red"
        ]);
        return redirect()->route('banner.index');
    }

    // Xóa banner
    public function destroy($id)
    {
        // Tìm bản ghi banner theo ID
        $banners = Banner::findOrFail($id);

        // Xóa bản ghi khỏi database
        $banners->delete();

        // Xóa file ảnh nếu tồn tại
        if ($banners->image_url && Storage::exists($banners->image_url)) {
            Storage::delete($banners->image_url);
        }

        // Sử dụng session để truyền toastr thông báo thành công
        toastr("Xóa thành công", NotificationInterface::SUCCESS, "Thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
            "color" => "red"
        ]);

        return redirect()->route('banner.index');
    }
}
