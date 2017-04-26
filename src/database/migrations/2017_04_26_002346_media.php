<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Media extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('media', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');
            $table->boolean('local');
            $table->string('extension');
            $table->integer('media_type_id')->unsigned();
            $table->foreign('media_type_id')
                ->references('id')->on('media_type')
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
        Schema::dropIfExists('media');
    }
}
