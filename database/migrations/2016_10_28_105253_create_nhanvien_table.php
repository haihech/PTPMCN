<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNhanvienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nhanvien', function (Blueprint $table) {
            $table->string('manv');
            $table->string('password');
            $table->string('ten');
            $table->string('sdt');
            $table->string('cmt');
            $table->string('diachi');
            $table->string('chucvu');
            $table->string('status');
            $table->string('img')->nullable();
            $table->primary('manv');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nhanvien');
    }
}
