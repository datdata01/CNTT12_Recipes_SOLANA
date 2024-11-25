<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreNewRoleRequest;
use App\Http\Requests\UpdateNewRoleRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Flasher\Prime\Notification\NotificationInterface;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class NewroleController extends Controller
{
    public function index()
    {
        $role = Role::all();
        // dd($role);
        return view("admin.pages.roles-permission.role.index", compact("role"));
    }
    public function store(StoreNewRoleRequest $request)
    {
        $role = Role::create([
            'name' => $request->name,
        ]);

        toastr("Thêm vai trò mới thành công!", NotificationInterface::SUCCESS, "Thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);

        return redirect()->route('new-role.index');
    }

    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        return view('admin.pages.roles-permission.role.edit', compact('role'));
    }

    public function update(UpdateNewRoleRequest $request, string $id)
    {
        $role = Role::findOrFail($id);
        $role->update([
            'name' => $request->name,
        ]);

        toastr('Cập nhật vai trò thành công!', NotificationInterface::SUCCESS, 'Thành công', [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
        ]);

        return redirect()->route("new-role.index");
    }

    public function destroy(string $id)
    {
        try {
            $role = Role::findOrFail($id); // Sử dụng findOrFail để ném ngoại lệ nếu không tìm thấy danh mục
            // Kiểm tra xem vai trò có liên kết hay không
            // if ($permission->roles()->count() > 0) {
            //     toastr("Không thể xóa danh mục này vì có liên kết.", NotificationInterface::ERROR, "Lỗi", [
            //         "closeButton" => true,
            //         "progressBar" => true,
            //         "timeOut" => "3000",
            //     ]);
            //     return redirect()->route("category-article.index");
            // }

            $role->delete();
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

        return redirect()->route("new-role.index");
    }
    public function addPermissionToRole($id){
        $permissions = Permission::get();
        $role = Role::findOrFail($id);
        return view("admin.pages.roles-permission.role.add-Permission-Role", compact("role","permissions"));
    }
    public function assignPermissions(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'permissions' => 'required|array',
        ], [
            'permissions.required' => 'Vui lòng chọn ít nhất một quyền.',
        ]);
        $role = Role::findOrFail($id);

        // Gán quyền cho vai trò
        $role->syncPermissions($request->permissions);

        toastr('Gán quyền thành công!', NotificationInterface::SUCCESS, 'Thành công', [
            'closeButton' => true,
            'progressBar' => true,
            'timeOut' => '3000',
        ]);

        return redirect()->route('new-role.index');
    }
}
