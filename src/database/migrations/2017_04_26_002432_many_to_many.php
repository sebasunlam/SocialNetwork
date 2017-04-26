<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ManyToMany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('imagen_perfil', function (Blueprint $table) {
            $table->timestamps();
            $table->integer('perfil_id')->unsigned();
            $table->integer('imagen_id')->unsigned();
            $table->foreign('perfil_id')
                ->references('id')->on('perfil')
                ->onDelete('cascade');
            $table->foreign('imagen_id')
                ->references('id')->on('imagen')
                ->onDelete('cascade');
        });

        Schema::create('imagen_mascota', function (Blueprint $table) {
            $table->timestamps();
            $table->integer('mascota_id')->unsigned();
            $table->integer('imagen_id')->unsigned();
            $table->foreign('mascota_id')
                ->references('id')->on('mascota')
                ->onDelete('cascade');
            $table->foreign('imagen_id')
                ->references('id')->on('imagen')
                ->onDelete('cascade');
        });

        Schema::create('mascota_perfil', function (Blueprint $table) {
            $table->timestamps();
            $table->integer('mascota_id')->unsigned();
            $table->integer('perfil_id')->unsigned();
            $table->foreign('perfil_id')
                ->references('id')->on('perfil')
                ->onDelete('cascade');
            $table->foreign('mascota_id')
                ->references('id')->on('mascota')
                ->onDelete('cascade');
        });

        Schema::create('perfil_like_post', function (Blueprint $table) {
            $table->timestamps();
            $table->string('coment');
            $table->boolean('like');
            $table->integer('perfil_id')->unsigned();
            $table->integer('post_id')->unsigned();
            $table->foreign('perfil_id')
                ->references('id')->on('perfil')
                ->onDelete('cascade');
            $table->foreign('post_id')
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
        Schema::dropIfExists('perfil_like_post');
        Schema::dropIfExists('imagen_perfil');
        Schema::dropIfExists('imagen_mascota');
        Schema::dropIfExists('mascota_perfil');
    }
}
