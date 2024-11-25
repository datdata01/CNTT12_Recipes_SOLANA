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
        Schema::table('refund_items', function (Blueprint $table) {
            // Xóa khóa ngoại cũ
            $table->dropForeign(['product_id']);
            
            // Xóa cột product_id
            $table->dropColumn('product_id');
            
            // Thêm cột product_variant_id mới
            $table->unsignedBigInteger('product_variant_id')->after('refund_id');
            
            // Thêm khóa ngoại mới cho product_variant_id
            $table->foreign('product_variant_id')->references('id')->on('product_variants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('refund_items', function (Blueprint $table) {
            // Xóa khóa ngoại của product_variant_id
            $table->dropForeign(['product_variant_id']);
            
            // Xóa cột product_variant_id
            $table->dropColumn('product_variant_id');
            
            // Thêm lại cột product_id
            $table->unsignedBigInteger('product_id')->after('refund_id');
            
            // Thêm khóa ngoại cho product_id
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }
};
