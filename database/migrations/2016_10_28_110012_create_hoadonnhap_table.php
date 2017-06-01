<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHoadonnhapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hoadonnhap', function (Blueprint $table) {
            $table->increments('id');
            $table->string('manv');
            $table->integer('nhacungcap_id')->unsigned();
            $table->foreign('manv')->references('manv')->on('nhanvien');
            $table->foreign('nhacungcap_id')->references('id')->on('nhacungcap');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hoadonnhap');
    }
}
