<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use DB;

class CreateSanphamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sanpham', function ($table) {
            $table->increments('id');
            $table->string('ten', 200);
            $table->integer('giaban');
            $table->string('anh', 200);
            $table->integer('discount');
            $table->integer('thuonghieu_id')->unsigned();
            $table->integer('nhomtuoi_id')->unsigned();
            $table->string('mota', 10000);
            $table->foreign('thuonghieu_id')->references('id')->on('thuonghieu');
            $table->foreign('nhomtuoi_id')->references('id')->on('nhomtuoi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sanpham');
    }
}
