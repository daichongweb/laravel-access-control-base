<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatGroupMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_group_members', function (Blueprint $table) {
            $table->id();
            $table->char('user_id', 64)->nullable(false)->comment('用户企业微信id');
            $table->tinyInteger('type')->nullable(false)->default(1)->comment('成员类型 1企业成员 2外部联系人');
            $table->tinyInteger('join_scene')->nullable(false)->default(1)->comment('入群方式 1由群成员邀请入群（直接邀请入群） 2由群成员邀请入群（通过邀请链接入群）3通过扫描群二维码入群');
            $table->char('invitor', 64)->nullable(false)->comment('邀请人id');
            $table->char('group_nickname', 64)->nullable(false)->comment('群昵称');
            $table->char('name', 64)->nullable(false)->comment('微信昵称');
            $table->integer('join_time')->nullable(false)->default(0);
            $table->tinyInteger('is_admin')->nullable(false)->default(0)->comment('0不是，1是');
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
        Schema::dropIfExists('chat_group_members');
    }
}
