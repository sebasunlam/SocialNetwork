<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Encontrado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('encontrado', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('contacto');
            $table->boolean('aceptada')->nullable();
            $table->integer('perfil_id')->unsigned();
            $table->integer('imagen_id')->unsigned();
            $table->integer('perdido_id')->unsigned();
            $table->foreign('perfil_id')
                ->references('id')->on('perfil')
                ->onDelete('cascade');
            $table->foreign('imagen_id')
                ->references('id')->on('imagen')
                ->onDelete('cascade');
            $table->foreign('perdido_id')
                ->references('id')->on('perdido')
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
        Schema::dropIfExists('encontrado');
    }
}
