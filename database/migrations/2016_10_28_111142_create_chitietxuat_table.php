<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChitietxuatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chitietxuat', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('soluong');
            $table->integer('giaban');
            $table->integer('hoadonxuat_id')->unsigned();
            $table->integer('sanpham_id')->unsigned();
            $table->date('hansudung');
            $table->foreign('hoadonxuat_id')->references('id')->on('hoadonxuat');
            $table->foreign('sanpham_id')->references('id')->on('sanpham');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chitietxuat');
    }
}
