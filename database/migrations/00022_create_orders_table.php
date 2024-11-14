<?php

use App\Models\AddressUser;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(AddressUser::class)->constrained();
            $table->decimal('total_amount', 15, 2);
            $table->enum('status', ['PENDING', 'DELIVERING', 'SHIPPED', 'COMPLETED', 'CANCELED']);
            $table->enum('payment_method', ['CASH', 'BANK_TRANSFER']);
            $table->enum('confirm_status', ['ACTIVE', 'IN_ACTIVE']);
            $table->text('note');
            $table->decimal('discount_amount', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
