<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCakindTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cakind', function (Blueprint $table) {
            $table->bigIncrements('cachetKindid');
            $table->integer('makerid')->comment('商家id');
            $table->string('cakindname')->comment('公章种类名称');
            $table->string('cachetExplain')->comment('公章种类说明');
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
        Schema::dropIfExists('cakind');
    }
}
