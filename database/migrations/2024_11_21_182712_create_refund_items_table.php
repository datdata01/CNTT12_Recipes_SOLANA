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
        Schema::create('refund_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('refund_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->string('img')->nullable();
            $table->text('description')->nullable();
            $table->enum('reason', [
                'NOT_RECEIVED',
                'MISSING_ITEMS',
                'DAMAGED_ITEMS',
                'INCORRECT_ITEMS',
                'FAULTY_ITEMS',
                'DIFFERENT_FROM_DESCRIPTION',
                'USED_ITEMS'
            ]);
            $table->enum('status', [
                'PENDING',
                'APPROVED',
                'REJECTED',
            ])->default('PENDING');
            $table->timestamps();
            $table->foreign('refund_id')->references('id')->on('refunds');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refund_items');
    }
};
