<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChitietnhapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chitietnhap', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('soluong');
            $table->integer('gianhap');
            $table->integer('hoadonnhap_id')->unsigned();
            $table->integer('sanpham_id')->unsigned();
            $table->date('hansudung');
            $table->foreign('hoadonnhap_id')->references('id')->on('hoadonnhap');
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
        Schema::dropIfExists('chitietnhap');
    }
}
