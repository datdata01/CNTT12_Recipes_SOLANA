<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Cập nhật enum với giá trị mới
            $table->enum('status', ['PENDING', 'DELIVERING', 'SHIPPED', 'COMPLETED', 'CANCELED', 'REFUND', 'PROCESSING'])
                ->default('PENDING')
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Khôi phục lại enum ban đầu
            $table->enum('status', ['PENDING', 'DELIVERING', 'SHIPPED', 'COMPLETED', 'CANCELED', 'REFUND'])
                ->default('PENDING')
                ->change();
        });
    }
};
