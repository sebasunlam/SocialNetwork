<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Departamento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('departamento', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion');
            $table->integer('provincia_id')->unsigned();
            $table->foreign('provincia_id')
                ->references('id')->on('provincia')
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
        Schema::dropIfExists('departamento');
    }
}
