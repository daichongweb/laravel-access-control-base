<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SaveChatGroupsIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chat_groups', function (Blueprint $table) {
            $table->dropIndex('chat_groups_enterprise_id_member_id_index');
            $table->unique(['enterprise_id', 'member_id', 'chat_id'], 'chat_unique');
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
            $table->index(['enterprise_id', 'member_id', 'chat_groups_enterprise_id_member_id_index']);
            $table->dropUnique('chat_unique');
        });
    }
}
