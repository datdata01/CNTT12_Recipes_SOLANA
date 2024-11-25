<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Định nghĩa quyền hạn cho các quản lý
        $permissions = [
            'dashboard', // Quyền xem thống kê
            'articles', // Quyền tổng quát cho quản lý bài viết
            'products', // Quyền tổng quát cho quản lý sản phẩm
            'users',    // Quyền tổng quát cho quản lý người dùng
            'voucher', // Quyền tổng quát cho quản lý phiếu giảm giá (sửa từ 'vouchers' thành 'voucher')
            'orders',   // Quyền tổng quát cho quản lý đơn hàng
            'feedback', // Quyền tổng quát cho quản lý phản hồi
            'banner',//Quền tổng quát cho banner
            'refund',//Quyền hoàn hàng
        ];

        // Tạo quyền nếu chưa tồn tại
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Tạo vai trò admin và gán quyền
        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->givePermissionTo($permissions);

        // Tạo vai trò staff và gán quyền
        $staffRole = Role::create(['name' => 'Staff']);
        $staffRole->givePermissionTo([
            'dashboard',
            'articles',    // Quản lý bài viết
            'products',    // Quản lý sản phẩm
            'voucher',     // Quản lý phiếu giảm giá
            'orders',      // Quản lý đơn hàng
            'feedback',    // Quản lý phản hồi
        ]);

        // Tạo vai trò client và gán quyền
        $clientRole = Role::create(['name' => 'Client']);
         // Tạo tài khoản admin
         $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'], // Email cố định cho admin
            [
                'full_name' => 'Admin 01',
                'phone' => '01234567890',
                'status' => 'ACTIVE',
                'email_verified_at'=> now(),
                'password' => bcrypt('admin12345'), // Mật khẩu mặc định
            ]
        );

        // Gán vai trò Admin cho tài khoản
        $admin->assignRole($adminRole, $staffRole, $clientRole);
    }
}
