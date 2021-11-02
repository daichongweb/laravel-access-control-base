<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfoIdChatGroupInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chat_group_members', function (Blueprint $table) {
            $table->integer('info_id')->after('member_id')->nullable(false)->comment('微信群详情id');
            $table->index(['info_id']);
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
            $table->dropColumn('info_id');
        });
    }
}
