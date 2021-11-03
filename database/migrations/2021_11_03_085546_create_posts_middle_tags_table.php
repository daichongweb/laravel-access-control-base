<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsMiddleTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts_middle_tags', function (Blueprint $table) {
            $table->id();
            $table->integer('tag_id')->nullable(false);
            $table->integer('post_id')->nullable(false);
            $table->timestamps();
            $table->index(['tag_id', 'post_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts_middle_tags');
    }
}
