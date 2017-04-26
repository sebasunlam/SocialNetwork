<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Perfil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('perfil', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('apellido');
            $table->string('nombre');
            $table->date('fechanacimiento');
            $table->string('telefono');
            $table->integer('user_id')->unsigned();
            $table->integer('sexo_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')->on('user')
                ->onDelete('cascade');
            $table->foreign('sexo_id')
                ->references('id')->on('sexo')
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
        Schema::dropIfExists('perfil');
    }
}
