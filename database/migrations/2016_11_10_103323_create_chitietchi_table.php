<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChitietchiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chitietchi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sotienchi');
            $table->integer('hoadonnhap_id')->unsigned();
            $table->integer('phieuchi_id')->unsigned();
            $table->foreign('hoadonnhap_id')->references('id')->on('hoadonnhap');
            $table->foreign('phieuchi_id')->references('id')->on('phieuchi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chitietchi');
    }
}
