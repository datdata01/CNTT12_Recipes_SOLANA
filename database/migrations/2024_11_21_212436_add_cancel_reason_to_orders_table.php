<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('cancel_reason', [
                'wrong_product',
                'change_of_mind',
                'price_too_high',
                'payment_issue',
                'long_wait_time',
                'other'
            ])->nullable()->after('status');
            $table->string('cancel_reason_other')->nullable()->after('cancel_reason');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('cancel_reason');
            $table->dropColumn('cancel_reason_other');
        });
    }
};
