<?php

use App\Models\Order;
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
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)->constrained();
            $table->enum('reason', [
                'NOT_RECEIVED', // Chưa nhận
                'MISSING_ITEMS', // Thiếu hàng
                'DAMAGED_ITEMS', // Vỡ hàng
                'INCORRECT_ITEMS', // Sai hàng
                'FAULTY_ITEMS', // Lỗi hàng
                'DIFFERENT_FRON_THE_DESCRIPTION', // Khác với mô tả
                'USED_ITEMS' // Hàng qua sử dụng
            ]);
            $table->text('description');
            $table->string('image');
            $table->enum('status', [
                'PENDING', // Đang chờ xử lý
                'APPROVED', // Đã được phê duyệt:
                'DENIED', // Bị từ chối
                'IN_TRÁNIT', // Đang vận chuyển
                'RETURN_ORDER_COMPLETED' // Đơn hoàn hàng đã hoàn tấ
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};
