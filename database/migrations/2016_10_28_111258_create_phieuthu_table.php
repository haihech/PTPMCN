<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhieuthuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phieuthu', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('phuongthucthanhtoan');
            $table->string('nhanvien_manv');
            $table->integer('khachhang_id')->unsigned();
            $table->foreign('khachhang_id')->references('id')->on('users');
            $table->foreign('nhanvien_manv')->references('manv')->on('nhanvien');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phieuthu');
    }
}
