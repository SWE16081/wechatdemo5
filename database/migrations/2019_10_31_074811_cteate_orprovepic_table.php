<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CteateOrprovepicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        公章证明图片表
        Schema::create('orprovepic', function (Blueprint $table) {
            $table->bigIncrements('orprovepicid')->comment('订单id');
            $table->integer('orderid')->comment('order表id');
            $table->string('cachetprove')->comment('公章证明');
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
        Schema::dropIfExists('orprovepic');
    }
}
