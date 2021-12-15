<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesMiddleRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_middle_rules', function (Blueprint $table) {
            $table->id();
            $table->integer('role_id');
            $table->integer('rule_id');
            $table->unique(['role_id', 'rule_id'], 'role_rule_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles_middle_rules');
    }
}
