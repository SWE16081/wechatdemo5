<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemindinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remindinfo', function (Blueprint $table) {
            $table->bigIncrements('remindinfoid');
            $table->integer('userid')->comment('商家id');
            $table->integer('orderid')->comment('订单id');
            $table->string('info')->nullable()->comment('提示信息');
            $table->string('backinfo')->nullable()->comment('商家回复信息');
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
        Schema::dropIfExists('remindinfo');
    }
}
