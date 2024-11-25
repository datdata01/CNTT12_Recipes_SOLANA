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
        // Kiểm tra và thêm cột 'used'
        if (!Schema::hasColumn('voucher_usages', 'used')) {
            Schema::table('voucher_usages', function (Blueprint $table) {
                $table->integer('used')->default(0)->after('voucher_id');
            });
        }

        // Kiểm tra và xóa từng cột riêng lẻ
        if (Schema::hasColumn('voucher_usages', 'vourcher_code')) {
            Schema::table('voucher_usages', function (Blueprint $table) {
                $table->dropColumn('vourcher_code');
            });
        }

        if (Schema::hasColumn('voucher_usages', 'start_date')) {
            Schema::table('voucher_usages', function (Blueprint $table) {
                $table->dropColumn('start_date');
            });
        }
        
        if (Schema::hasColumn('voucher_usages', 'end_date')) {
            Schema::table('voucher_usages', function (Blueprint $table) {
                $table->dropColumn('end_date');
            });
        }

        if (Schema::hasColumn('voucher_usages', 'status')) {
            Schema::table('voucher_usages', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('voucher_usages', function (Blueprint $table) {
            // Xóa cột 'used' nếu tồn tại
            if (Schema::hasColumn('voucher_usages', 'used')) {
                $table->dropColumn('used');
            }

            // Thêm lại các cột bị xóa nếu chưa tồn tại
            if (!Schema::hasColumn('voucher_usages', 'vourcher_code')) {
                $table->string('vourcher_code')->nullable();
            }

            if (!Schema::hasColumn('voucher_usages', 'start_date')) {
                $table->date('start_date')->nullable();
            }

            if (!Schema::hasColumn('voucher_usages', 'end_date')) {
                $table->date('end_date')->nullable();
            }

            if (!Schema::hasColumn('voucher_usages', 'status')) {
                $table->string('status')->nullable();
            }
        });
    }
};
