<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Đặt giá trị mặc định trước khi thay đổi enum
        DB::table('banners')->whereNotIn('image_type', [
            'HEADER', 'CONTENT-LEFT-TOP', 'CONTENT-LEFT-BELOW', 
            'CONTENT-RIGHT', 'SUBSCRIBE-NOW-EMAIL', 'BANNER-LEFT', 'BANNER-RIGHT'
        ])->update(['image_type' => 'HEADER']);

        Schema::table('banners', function (Blueprint $table) {
            $table->enum('image_type', [
                'HEADER', 
                'CONTENT-LEFT-TOP', 
                'CONTENT-LEFT-BELOW', 
                'CONTENT-RIGHT', 
                'SUBSCRIBE-NOW-EMAIL', 
                'BANNER-LEFT', 
                'BANNER-RIGHT'
            ])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->enum('image_type', ['HEADER', 'CONTENT'])->change();
        });
    }
};
