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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->integer('limit');
            $table->enum('discount_type', ['PERCENTAGE', 'FIXED']);
            $table->decimal('discount_value', 15, 2);
            $table->decimal('min_order_value', 15, 2);
            $table->decimal('max_order_value', 15, 2);
            $table->enum('status', ['ACTIVE', 'IN_ACTIVE'])->default('ACTIVE');
            $table->integer('voucher_used')->default(0);
            $table->dateTime('start_date'); // start date , end date
            $table->dateTime('end_date'); // start date , end date
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
