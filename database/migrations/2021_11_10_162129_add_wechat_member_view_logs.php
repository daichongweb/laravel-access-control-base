<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWechatMemberViewLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wechat_member_view_logs', function (Blueprint $table) {
            $table->integer('view_num')->nullable(false)->default(0)->comment('浏览次数');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wechat_member_view_logs', function (Blueprint $table) {
            $table->dropColumn('view_num');
        });
    }
}