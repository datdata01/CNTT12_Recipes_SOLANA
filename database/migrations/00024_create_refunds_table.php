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
            $table->string('code', 14);
            $table->string('image');
            // Thêm cột status với các giá trị có thể có
            $table->enum('status', [
                'ORDER_CREATED',              // Tạo đơn thành công
                'CANCEL_REFUND_ORDER',        // Hủy đơn hoàn
                'HANDOVER_TO_SHIPPING',       // Giao cho đơn vị vận chuyển
                'REFUND_COMPLETED',           // Đã hoàn hàng thành công
                'DELIVERY_FAILED'             // Giao hàng thất bại
            ])->default('ORDER_CREATED');  // Thiết lập giá trị mặc định
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
