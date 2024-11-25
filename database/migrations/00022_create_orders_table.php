<?php

use App\Models\AddressUser;
use App\Models\User;
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
            $table->foreignIdFor(User::class)->constrained();
            $table->decimal('total_amount', 15, 2);
            $table->enum('status', ['PENDING', 'DELIVERING', 'SHIPPED', 'COMPLETED', 'CANCELED', 'REFUND']);
            $table->enum('payment_method', ['CASH', 'BANK_TRANSFER']);
            $table->enum('confirm_status', ['ACTIVE', 'IN_ACTIVE']);
            $table->text('note')->nullable();
            $table->string('code', 14);
            $table->string('phone', 14);
            $table->string('customer_name', 100);
            $table->string('full_address', 200);
            $table->decimal('discount_amount', 15, 2)->nullable();
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
