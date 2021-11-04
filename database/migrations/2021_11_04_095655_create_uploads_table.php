<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploads', function (Blueprint $table) {
            $table->id();
            $table->integer('enterprise_id')->nullable(false)->comment('企业id')->index();
            $table->integer('member_id')->nullable(false);
            $table->char('file_path', 254)->nullable(false)->comment('文件路径');
            $table->char('suffix', 16)->nullable(false)->default('')->comment('文件后缀');
            $table->char('service', 16)->nullable(false)->default('huawei')->comment('服务商');
            $table->char('type', 16)->nullable(false)->comment('文件类型：image图片，txt文本，file文件');
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
        Schema::dropIfExists('uploads');
    }
}
