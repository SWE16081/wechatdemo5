<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMakerinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('makerinfo', function (Blueprint $table) {
            $table->bigIncrements('makerinfoid');
            $table->integer('userid')->comment('商家id');
            $table->string('companyinfo')->nullable()->comment('公司信息');
            $table->string('proveinfo')->nullable()->comment('商家证明材料');
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
        Schema::dropIfExists('makerinfo');
    }
}
