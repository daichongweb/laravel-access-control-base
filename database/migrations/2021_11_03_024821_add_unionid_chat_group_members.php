<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnionidChatGroupMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chat_group_members', function (Blueprint $table) {
            $table->char('unionid', 64)->after('user_id')->nullable(false)->comment('微信公众平台唯一id');
            $table->index(['unionid']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chat_group_members', function (Blueprint $table) {
            $table->dropColumn('unionid');
        });
    }
}
