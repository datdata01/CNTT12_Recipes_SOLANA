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
        Schema::table('refunds', function (Blueprint $table) {
            $table->dropColumn(['image', 'description', 'reason']);
            $table->string('code', 14)->unique()->change();
            $table->enum('status', [
                'PENDING',       // Đang chờ xử lý
                'APPROVED',      // Đã được phê duyệt
                'IN_TRANSIT',    // Đang vận chuyển
                'COMPLETED',     // Hoàn tất
            ])->default('PENDING')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('refunds', function (Blueprint $table) {
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->enum('reason', [
                'NOT_RECEIVED',
                'MISSING_ITEMS',
                'DAMAGED_ITEMS',
                'INCORRECT_ITEMS',
                'FAULTY_ITEMS',
                'DIFFERENT_FRON_THE_DESCRIPTION',
                'USED_ITEMS'
            ])->nullable();
            $table->dropUnique(['code']);
            $table->enum('status', [
                'ORDER_CREATED',
                'CANCEL_REFUND_ORDER',
                'HANDOVER_TO_SHIPPING',
                'REFUND_COMPLETED',
                'DELIVERY_FAILED'
            ])->default('ORDER_CREATED')->change();
        });
    }
};
