<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnterprises extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enterprises', function (Blueprint $table) {
            $table->id();
            $table->char('name', 64)->nullable(false)->comment('企业名称');
            $table->char('key', 32)->nullable(false)->index('key_index')->unique()->comment('企业唯一的key');
            $table->char('corp_id', 24)->nullable(false)->comment('企业微信id');
            $table->char('corp_secret', 64)->nullable(false)->comment('企业微信secret');
            $table->char('app_id', 24)->nullable(false)->comment('公众号id');
            $table->char('app_secret', 24)->nullable(false)->comment('公众号secret');
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
        Schema::dropIfExists('enterprises');
    }
}
