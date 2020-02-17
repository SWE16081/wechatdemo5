<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopcarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //            Shopcar(shopcarid,buyerid,cachetid,number, updated_at,created_at)
//            (购物车id,插入的是买家的id,公章id,数量)
        Schema::create('shopcar', function (Blueprint $table) {
            $table->bigIncrements('shopcarid')->comment('购物车id');
            $table->integer('buyerid')->comment('买家的user表id');
            $table->integer('cachetid')->comment('公章id');
            $table->integer('cachetkindid')->comment('公章种类id');
            $table->string('cachetname')->comment('公章名称');
            $table->string('cachetsize')->comment('公章大小');
            $table->string('picpath')->comment('公章图片路径');
            $table->string('cachetcolor')->comment('公章颜色');
            $table->string('cachetinfo')->comment('刻字内容');
            $table->integer('number')->comment('公章数量');
            $table->double('price')->comment('单价');
            $table->boolean('checkboxchoose')->default(false)->comment('公章选中状态');
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
        Schema::dropIfExists('shopcar');
    }
}
