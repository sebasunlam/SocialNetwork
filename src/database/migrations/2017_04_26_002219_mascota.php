<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Mascota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('mascota', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('nombre');
            $table->integer('dia')->nullable();
            $table->integer('mes')->nullable();
            $table->integer('anio');
            $table->boolean('adopcion')->default(false);
            $table->boolean('perdido')->default(false);
            $table->boolean('cita')->default(false);


            $table->integer('perfil_id')->unsigned();
            $table->integer('sexo_id')->unsigned();
            $table->integer('tamanio_id')->unsigned();
            $table->integer('raza_id')->unsigned();
            $table->foreign('perfil_id')
                ->references('id')->on('perfil')
                ->onDelete('cascade');
            $table->foreign('sexo_id')
                ->references('id')->on('sexo')
                ->onDelete('cascade');
            $table->foreign('tamanio_id')
                ->references('id')->on('tamanio')
                ->onDelete('cascade');
            $table->foreign('raza_id')
                ->references('id')->on('raza')
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
        Schema::dropIfExists('mascota');
    }
}
