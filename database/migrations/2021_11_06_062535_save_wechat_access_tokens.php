<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SaveWechatAccessTokens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wechat_access_tokens', function (Blueprint $table) {
            $table->string('access_token', 128)->nullable(false)->change();
            $table->string('refresh_token', 128)->nullable(false)->change();
            $table->string('unionid', 128)->nullable(false)->default('');
            $table->dropColumn('open_id');
            $table->string('openid', 64)->nullable(false);
        });
    }
}
