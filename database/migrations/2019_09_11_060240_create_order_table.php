<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->bigIncrements('orderid')->comment('订单id');
            $table->integer('userid')->comment('买家user表id');
            $table->integer('makerid')->comment('商家user表id');
            $table->string('cachetid')->comment('公章表id');
            $table->string('cachetname')->comment('公章名称');
            $table->string('cachetsize')->comment('公章大小');
            $table->string('cachetcolor')->comment('公章颜色');
            $table->string('number')->comment('公章数量');
            $table->string('price')->comment('单价');
            $table->string('picpath')->comment('公章图片路径');
            $table->string('cachetinfo')->comment('刻字内容');
            $table->double('totalprice')->comment('总价');
            $table->string('name')->comment('收件人');
            $table->string('phone')->comment('手机号');
            $table->string('deliverway')->comment('配送方式');
            $table->string('address')->nullable()->comment('地址');
//            $table->string('cachetprove')->comment('公章证明');
            $table->string('state')->comment('订单状态');//1为代付款2为待发货，3为待收货4为消息
            $table->string('explain')->nullable()->comment('订单说明');
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
        Schema::dropIfExists('order');
    }
}
