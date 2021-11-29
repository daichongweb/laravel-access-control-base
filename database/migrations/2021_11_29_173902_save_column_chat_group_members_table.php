<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SaveColumnChatGroupMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Models\ChatGroupMembersModel::query()->delete();
        Schema::table('chat_group_members', function (Blueprint $table) {
            $table->dropColumn('info_id');
            $table->integer('group_id')->nullable(false)->comment('群id')->index();
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
            $table->dropColumn('group_id');
            $table->integer('info_id')->nullable(false)->comment('群id')->index();
        });
    }
}
