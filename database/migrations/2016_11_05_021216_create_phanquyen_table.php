<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhanquyenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phanquyen', function (Blueprint $table) {
            $table->increments('id');
            $table->string('quyen_id');
            $table->string('nhanvien_manv');
            $table->foreign('quyen_id')->references('id')->on('quyen');
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
        Schema::dropIfExists('phanquyen');
    }
}
