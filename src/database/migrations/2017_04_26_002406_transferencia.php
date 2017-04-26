<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Transferencia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('post', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('cntent');
            $table->integer('mascota_id')->unsigned();
            $table->integer('media_id')->unsigned()->nullable();
            $table->foreign('mascota_id')
                ->references('id')->on('mascota')
                ->onDelete('cascade');
            $table->foreign('media_id')
                ->references('id')->on('media')
                ->onDelete('cascade');
        });

        Schema::create('transferencia', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->boolean('aceptada')->nullable();
            $table->integer('perfil_id')->unsigned();
            $table->integer('mascota_id')->unsigned();
            $table->foreign('perfil_id')
                ->references('id')->on('perfil')
                ->onDelete('cascade');
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
        Schema::dropIfExists('post');
        Schema::dropIfExists('transferencia');
    }
}
