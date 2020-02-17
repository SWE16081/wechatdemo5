<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {
            $table->bigIncrements('addressid');
            $table->integer('userid')->comment('用户id');
            $table->string('name')->comment('收货人');
            $table->string('phone')->comment('手机号');
            $table->string('city')->comment('城市');
            $table->string('address')->comment('详细地址');
            $table->boolean('checked')->default(false)->comment('是否有设为默认地址');
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
        Schema::dropIfExists('address');
    }
}
