<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\user\StoreUserRequest;
use App\Http\Requests\Admin\user\UpdateUserRequest;
use App\Models\User;
use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class NewUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::get();

        return view('admin.pages.roles-permission.user.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id')->all();

        return view('admin.pages.roles-permission.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated(); // Chỉ lấy dữ liệu đã được xác thực
        try {
            // Xử lý hình ảnh nếu có
            if ($request->hasFile('image')) {
                $data['image'] = Storage::put('users', $request->file('image'));
            }
            // dd($data);
            // Tạo người dùng
            $user = User::create($data);

            // Gán nhiều vai trò cho người dùng
            $user->roles()->sync($data['roles']);

            // Thông báo thành công
            toastr("Thêm mới người dùng thành công", NotificationInterface::SUCCESS, "Thành công", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000"
            ]);

            return redirect()->route('new-user.index'); // Chuyển hướng về danh sách người dùng
        } catch (\Throwable $th) {
            // Thông báo thất bại
            toastr("Thêm mới người dùng thất bại: " . $th->getMessage(), NotificationInterface::ERROR, "Thất bại", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000"
            ]);

            return back()->withInput(); // Giữ lại dữ liệu cũ
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($user)
    {
        // return $user;
        $roles = Role::pluck('name', 'id')->all();
        $user = User::findOrFail($user);
        // dd($user);
        return view('admin.pages.roles-permission.user.edit', compact('roles', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $id)
    {
        // Lấy dữ liệu đã được xác thực từ request
        $data = $request->validated();

        try {
            // Lấy thông tin người dùng
            $user = User::findOrFail($id);

            // Kiểm tra nếu có ảnh được tải lên
            if ($request->hasFile('image')) {
                // Xóa ảnh cũ nếu có
                if (!empty($user->image) && Storage::exists($user->image)) {
                    Storage::delete($user->image);
                }

                // Lưu ảnh mới
                $data['image'] = $request->file('image')->store('users', 'public');
            }

            // Cập nhật thông tin người dùng
            $user->update($data);
            // Cập nhật vai trò nếu có
            $roles = $data['roles'];
            // dd($roles);
            $user->roles()->sync($data['roles']);

            // Thông báo thành công
            toastr('Cập nhật người dùng thành công',NotificationInterface::SUCCESS, 'Thành công', [
                'closeButton' => true,
                'progressBar' => true,
                'timeOut' => 3000,
            ]);
            return redirect()->route('new-user.index');
        } catch (\Exception $e) {
            // Thông báo lỗi
            toastr()->error('Đã xảy ra lỗi khi cập nhật người dùng: ' . $e->getMessage(), 'Lỗi', [
                'closeButton' => true,
                'progressBar' => true,
            ]);

            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->roles()->detach();

            $imagePath = $user->image;

            $user->delete();

            if (!empty($imagePath) && Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }

            toastr("Xoá người dùng thành công", NotificationInterface::SUCCESS, "Thành công", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
                "color" => "red"
            ]);

            return back();
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            toastr("Xoá người dùng thất bại", NotificationInterface::ERROR, "Thất bại", [
                "closeButton" => true,
                "progressBar" => true,
                "timeOut" => "3000",
                "color" => "red"
            ]);

            return back();
        }
    }
}
