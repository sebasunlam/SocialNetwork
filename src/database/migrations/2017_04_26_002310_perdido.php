<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Perdido extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('perdido', function (Blueprint $table) {
            $table->increments('id');
            $table->double('lat');
            $table->double('long');
            $table->integer('mascota_id')->unsigned();
            $table->foreign('mascota_id')
                ->references('id')->on('mascota')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('perdido');
    }
}
