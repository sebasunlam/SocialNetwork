<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Cita extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('cita', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('acepta')->nullable();
            $table->timestamps();
            $table->integer('buscando')->unsigned();
            $table->integer('ofrecida')->unsigned();
            $table->foreign('buscando')
                ->references('id')->on('mascota')
                ->onDelete('cascade');
            $table->foreign('ofrecida')
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
        Schema::dropIfExists('cita');
    }
}
