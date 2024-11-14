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
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['user_id', 'product_id']); // Đảm bảo mỗi sản phẩm chỉ được yêu thích một lần bởi một người dùng
        });

        Schema::table('products', function (Blueprint $table) {
            // Thêm cột 'view' kiểu integer để lưu số lượt xem sản phẩm
            $table->integer('view')->default(0); // Đặt giá trị mặc định là 0
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
        Schema::table('products', function (Blueprint $table) {
            // Xóa cột 'view' khi rollback migration
            $table->dropColumn('view');
        });
    }
};
