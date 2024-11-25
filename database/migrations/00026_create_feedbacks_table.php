<?php

use App\Models\OrderItem;
use App\Models\Product;
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
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(OrderItem::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->bigInteger('parent_feedback_id')->nullable()->default(null);
            $table->enum('rating', [1, 2, 3, 4, 5]);
            $table->text('comment')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
