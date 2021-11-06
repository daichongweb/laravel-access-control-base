<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWechatMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_members', function (Blueprint $table) {
            $table->id();
            $table->integer('enterprise_id')->nullable(false)->comment('企业id')->index();
            $table->string('open_id', 64)->nullable(false)->comment('用户唯一标识')->index();
            $table->string('nickname', 128)->nullable(false)->default('');
            $table->tinyInteger('sex')->nullable(false)->default(0);
            $table->string('province', 24)->default('')->nullable(false);
            $table->string('city', 24)->default('')->nullable(false);
            $table->string('country', 24)->default('')->nullable(false);
            $table->string('headimgurl', 254)->default('')->nullable(false);
            $table->string('unionid', 64)->default('')->nullable(false)->index();
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
        Schema::dropIfExists('wechat_members');
    }
}
