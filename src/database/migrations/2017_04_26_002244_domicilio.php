<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Domicilio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('domicilio', function (Blueprint $table) {
            $table->increments('id');

            $table->timestamps();
            $table->string('calle');
            $table->integer('numero')->nullable();
            $table->double('lat');
            $table->double('long');
            $table->integer('perfil_id')->unsigned();
            $table->integer('localidad_id')->unsigned();
            $table->foreign('perfil_id')
                ->references('id')->on('perfil')
                ->onDelete('cascade');
            $table->foreign('localidad_id')
                ->references('id')->on('localidad')
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
        Schema::dropIfExists('domicilio');
    }
}
