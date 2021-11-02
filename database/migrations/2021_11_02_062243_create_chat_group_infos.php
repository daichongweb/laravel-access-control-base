<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatGroupInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_group_infos', function (Blueprint $table) {
            $table->id();
            $table->char('chat_id', 32)->nullable(false)->comment('群id');
            $table->char('chat_name', 80)->nullable(false)->default('');
            $table->char('owner', 64)->nullable(false)->comment('用户企业微信id');
            $table->smallInteger('member_num')->nullable(false)->default(0)->comment('普通成员人数');
            $table->smallInteger('admin_num')->nullable(false)->default(0)->comment('管理员人数');
            $table->integer('create_time')->nullable(false)->default(0)->comment('创建时间');
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
        Schema::dropIfExists('chat_group_infos');
    }
}
