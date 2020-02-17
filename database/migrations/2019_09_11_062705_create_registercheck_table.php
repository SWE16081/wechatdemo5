<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistercheckTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        商家注册审核表:
//        Registercheck(checkid,makerid,state, updated_at,created_at)
//        (商家注册的openid,审核状态)
        Schema::create('registercheck', function (Blueprint $table) {
            $table->bigIncrements('checkid');
            $table->string('makerid')->comment('商家注册的openid');
            $table->string('state')->comment('审核状态');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registercheck');
    }
}
