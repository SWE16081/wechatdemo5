<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCachetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cachet', function (Blueprint $table) {
            $table->bigIncrements('cachetid')->comment('公章id');
            $table->string('makerid')->comment('商家的user表id');
            $table->string('cachetKindid')->comment('公章种类id');
            $table->string('cachettagname')->comment('公章标签名称');
            $table->string('cachetPrice')->comment('公章价格');
            $table->integer('cachetNum')->default(0)->comment('销售量');
            $table->string('cachetPicPath')->nullable()->comment('公章图片路径');
            $table->string('cachetSize')->comment('公章大小');
            $table->string('cachetColor')->comment('公章颜色');
//            $table->string('cachetShape')->nullable()->comment('公章形状');
//            $table->string('cachetExplain')->nullable()->comment('公章说明');
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
        Schema::dropIfExists('cachet');
    }
}
