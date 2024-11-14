<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->string('file_path')->nullable()->change();
            $table->string('comment')->nullable()->change();
            $table->string('parent_feedback_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->string('file_path')->default('')->change(); // Hoặc loại bỏ nullable nếu cần
            $table->string('comment')->default('')->change();
            $table->string('parent_feedback_id')->default('')->change();
        });
    }
};
