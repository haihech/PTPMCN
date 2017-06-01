<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHoadonxuatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hoadonxuat', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('khachhang_id')->unsigned();
            $table->string('diachigiaohang');
            $table->string('phuongthucthanhtoan');
            $table->integer('phiship');
            $table->string('trangthai');
            $table->string('nguoixuatkho');
            $table->string('nguoigiaohang');
            $table->foreign('nguoixuatkho')->references('manv')->on('nhanvien');
            $table->foreign('nguoigiaohang')->references('manv')->on('nhanvien');
            $table->foreign('khachhang_id')->references('id')->on('users');
            $table->string('note', 10000);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hoadonxuat');
    }
}
