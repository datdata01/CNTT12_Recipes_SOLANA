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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('code', 8);
            $table->string('phone', 14);
            $table->string('customer_name', 100);
            $table->string('full_address', 200);
            $table->dropForeign(['address_user_id']);
            $table->dropColumn('address_user_id');
            $table->foreignIdFor(User::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('code');
            $table->dropColumn('phone');
            $table->dropColumn('customer_name');
            $table->dropColumn('full_address');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->foreignIdFor(AddressUser::class)->constrained();
        });
    }
};
