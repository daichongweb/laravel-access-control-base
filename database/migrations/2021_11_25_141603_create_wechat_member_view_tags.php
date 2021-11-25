<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWechatMemberViewTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_member_view_tags', function (Blueprint $table) {
            $table->id();
            $table->integer('enterprise_id')->nullable(false)->comment('企业id');
            $table->integer('wechat_member_id')->nullable(false);
            $table->integer('tag_id')->nullable(false);
            $table->integer('view_num')->nullable(false)->default(0);
            $table->timestamps();
            $table->unique(['enterprise_id', 'wechat_member_id', 'tag_id'],'tag_view');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wechat_member_view_tags');
    }
}
