<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWechatAccessTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->integer('enterprise_id')->nullable(false)->comment('企业id')->index();
            $table->string('access_token', 64)->nullable(false)->comment('access_token');
            $table->integer('expires_in')->nullable(false)->default(0)->comment('token过期时间单位秒');
            $table->string('refresh_token', 64)->nullable(false)->comment('用户刷新access_token');
            $table->string('open_id', 64)->nullable(false)->comment('用户唯一标识')->index();
            $table->string('scope', 128)->nullable(false)->comment('用户授权作用域');
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
        Schema::dropIfExists('wechat_access_tokens');
    }
}
