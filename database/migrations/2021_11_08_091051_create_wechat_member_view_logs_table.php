<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWechatMemberViewLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_member_view_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('enterprise_id')->nullable(false)->comment('企业id');
            $table->integer('wechat_member_id')->nullable(false);
            $table->integer('post_id')->nullable(false);
            $table->unique(['enterprise_id', 'wechat_member_id', 'post_id'], 'member_posts_index');
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
        Schema::dropIfExists('wechat_member_view_logs');
    }
}
