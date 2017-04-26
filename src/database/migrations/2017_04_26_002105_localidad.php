<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Localidad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('localidad', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion');
            $table->integer('departamento_id')->unsigned();
            $table->foreign('departamento_id')
                ->references('id')->on('departamento')
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
        Schema::dropIfExists('localidad');
    }
}
