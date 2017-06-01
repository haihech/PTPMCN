<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiohangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('giohang', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('soluong');
            $table->timestamps('thoigian');
            $table->integer('khachhang_id')->unsigned();
            $table->integer('sanpham_id')->unsigned();
            $table->foreign('khachhang_id')->references('id')->on('users');
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
        Schema::dropIfExists('giohang');
    }
}
