<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IntoColumnChatGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chat_groups', function (Blueprint $table) {
            $table->char('owner', 64)->nullable(false)->comment('群主，用户企业微信id');
            $table->smallInteger('member_num')->nullable(false)->default(0)->comment('普通成员人数');
            $table->smallInteger('admin_num')->nullable(false)->default(0)->comment('管理员人数');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chat_groups', function (Blueprint $table) {
            $table->dropColumn('owner', 64);
            $table->dropColumn('member_num');
            $table->dropColumn('admin_num');
        });
    }
}
