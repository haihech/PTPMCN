<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChitietthuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chitietthu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sotienthu');
            $table->integer('hoadonxuat_id')->unsigned();
            $table->integer('phieuthu_id')->unsigned();
            $table->foreign('hoadonxuat_id')->references('id')->on('hoadonxuat');
            $table->foreign('phieuthu_id')->references('id')->on('phieuthu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chitietthu');
    }
}
