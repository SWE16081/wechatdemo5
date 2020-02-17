<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('用户id');
            $table->string('name')->comment('用户账号');
            $table->string('password')->comment('用户密码');
            $table->integer('role')->default(1)->comment('用户角色默认为1是普通用户');
            $table->string('openid')->comment('微信openid');
            $table->string('session_key')->comment('微信的session_key');
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
        Schema::dropIfExists('users');
    }
}
