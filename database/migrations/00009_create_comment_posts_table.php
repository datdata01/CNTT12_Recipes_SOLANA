<?php

use App\Models\Article;
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
        Schema::create('comment_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Article::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->bigInteger('parent_comment_id')->nullable()->default(null);
            $table->text('comment');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_posts');
    }
};
