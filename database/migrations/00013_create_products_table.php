<?php

use App\Models\CategoryProduct;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CategoryProduct::class)->constrained();
            $table->string('name');
            $table->string('code', 50)->unique();
            $table->longText('description')->nullable();
            $table->string('image');
            $table->enum('status', ['ACTIVE', 'IN_ACTIVE']);
            $table->integer('love')->default(0);
            $table->integer('view')->default(0); // Đặt giá trị mặc định là 0
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
