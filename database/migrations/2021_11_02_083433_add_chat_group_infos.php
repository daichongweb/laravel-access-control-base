<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChatGroupInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chat_group_infos', function (Blueprint $table) {
            $table->integer('enterprise_id')->after('id')->nullable(false)->comment('企业id');
            $table->integer('member_id')->after('enterprise_id')->nullable(false)->comment('成员id');
            $table->index(['enterprise_id', 'member_id', 'chat_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chat_group_infos', function (Blueprint $table) {
            $table->dropColumn('enterprise_id');
            $table->dropColumn('member_id');
        });
    }
}
