<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Các cột bổ sung để tăng cường bảo mật
            $table->integer('login_attempts')->default(0)->after('password');     // Đếm số lần đăng nhập thất bại
            $table->timestamp('last_login_attempt')->nullable()->after('login_attempts'); // Thời điểm đăng nhập thất bại cuối
            $table->timestamp('password_changed_at')->nullable()->after('last_login_attempt'); // Lần thay đổi mật khẩu cuối
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Xóa các cột khi rollback
            $table->dropColumn('login_attempts');
            $table->dropColumn('last_login_attempt');
            $table->dropColumn('password_changed_at');
        });
    }
};
