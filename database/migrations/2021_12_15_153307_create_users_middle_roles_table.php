<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersMiddleRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_middle_roles', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable(false);
            $table->integer('role_id')->nullable(false);
            $table->unique(['user_id', 'role_id'], 'user_role_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_middle_roles');
    }
}
