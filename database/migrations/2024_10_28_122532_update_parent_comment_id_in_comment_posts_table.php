<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateParentCommentIdInCommentPostsTable extends Migration
{
    public function up()
    {
        Schema::table('comment_posts', function (Blueprint $table) {
            $table->integer('parent_comment_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('comment_posts', function (Blueprint $table) {
            $table->integer('parent_comment_id')->nullable(false)->change();
        });
    }
}
