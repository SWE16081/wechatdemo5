<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSckindTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sckind', function (Blueprint $table) {
            $table->bigIncrements('sckindid')->comment('购物车id');
            $table->integer('cachetKindid')->comment('公章种类id');
            $table->integer('userid')->comment('用户');
            $table->boolean('kindchoosed')->default(false)->comment('公章种类选中状态');
//            $table->boolean('allchoose')->default(false)->comment('全选中状态');
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
        Schema::dropIfExists('sckind');
    }
}
