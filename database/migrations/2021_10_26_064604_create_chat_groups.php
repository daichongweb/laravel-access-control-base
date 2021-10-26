<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_groups', function (Blueprint $table) {
            $table->id();
            $table->integer('enterprise_id')
                ->nullable(false)
                ->comment('企业id');
            $table->integer('member_id')
                ->nullable(false)
                ->default(0)
                ->comment('成员id');
            $table->char('chat_id', 32)
                ->nullable(false)
                ->comment('群id');
            $table->char('chat_name', '80')->nullable(false)->default('');
            $table->tinyInteger('status')->nullable(false)->default(0);
            $table->timestamps();
            $table->index(['enterprise_id', 'member_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_groups');
    }
}
