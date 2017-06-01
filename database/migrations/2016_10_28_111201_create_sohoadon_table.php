<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSohoadonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sohoadon', function (Blueprint $table) {
            $table->increments('sohoadon');
            $table->integer('hoadonxuat_id')->unsigned();
            $table->foreign('hoadonxuat_id')->references('id')->on('hoadonxuat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sohoadon');
    }
}
