<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->integer('enterprise_id')
                ->nullable(false)
                ->comment('企业id');
            $table->char('corp_user_id', 64)
                ->nullable(false)
                ->comment('用户企业微信id');
            $table->char('name', 64)
                ->nullable(false)
                ->comment('用户名');
            $table->char('email', 64)
                ->nullable(false)
                ->comment('邮箱');
            $table->char('password', 64)
                ->nullable(false)
                ->comment('密码');
            $table->timestamps();
            $table->unique(['enterprise_id', 'name']);
            $table->unique(['enterprise_id', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
