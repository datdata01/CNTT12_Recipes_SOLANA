<?php

namespace App\Http\Controllers\Admin;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Flasher\Prime\Notification\NotificationInterface;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        // dd($permissions);
        return view("admin.pages.roles-permission.permission.index", compact("permissions"));
    }
    public function store(StorePermissionRequest $request)
    {
        $permission = Permission::create([
            'name' => $request->name,
        ]);

        toastr("Thêm quyền mới thành công!", NotificationInterface::SUCCESS, "Thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);

        return redirect()->route('permission.index');
    }

    public function edit(string $id)
    {
        $permission = Permission::findOrFail($id);
        return view('admin.pages.roles-permission.permission.edit', compact('permission'));
    }

    public function update(UpdatePermissionRequest $request, string $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->update([
            'name' => $request->name,
        ]);

        toastr('Cập nhật quyền thành công!', NotificationInterface::SUCCESS, 'Thành công', [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);

        return redirect()->route("permission.index");
    }

    public function destroy(string $id)
    {
        try {
            $permission = Permission::findOrFail($id); // Sử dụng findOrFail để ném ngoại lệ nếu không tìm thấy danh mục
            // Kiểm tra xem quyền có liên kết hay không
            // if ($permission->roles()->count() > 0) {
            //     toastr("Không thể xóa danh mục này vì có liên kết.", NotificationInterface::ERROR, "Lỗi", [
            //         "closeButton" => true,
            //         "progressBar" => true,
            //         "timeOut" => "3000",
            //     ]);
            //     return redirect()->route("category-article.index");
            // }

            $permission->delete();
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

        return redirect()->route("permission.index");
    }
}
