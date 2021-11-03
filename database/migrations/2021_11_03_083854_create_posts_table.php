<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->integer('enterprise_id')->nullable(false)->comment('企业id')->index();
            $table->integer('member_id')->nullable(false)->comment('成员id')->index();
            $table->char('title', 64)->nullable(false)->default('')->comment('文章标题');
            $table->char('cover', 254)->nullable(false)->default('')->comment('封面图');
            $table->longText('content')->comment('文章内容');
            $table->integer('collect_num')->nullable(false)->default(0)->comment('收藏数量');
            $table->integer('share_num')->nullable(false)->default(0)->comment('分享数量');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
