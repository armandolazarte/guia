<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CarpetasArchivos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carpetas', function(Blueprint $table) {
            $table->increments('id');
            $table->string('ruta');
            $table->integer('folder_size')->unsigned();
            $table->boolean('zip');
        });

        Schema::create('carpeta_documentos', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('carpeta_id')->unsigned();
            $table->integer('documento_id')->unsigned();
            $table->string('documento_type');
        });

        Schema::create('archivos', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('carpeta_id')->unsigned();
            $table->integer('documento_id')->unsigned();
            $table->string('documento_type');
            $table->string('name');
            $table->string('mime');
            $table->integer('size')->unsigned();
            $table->dateTime('created_original');
            $table->string('extension', 10);
            $table->string('ruta');
            $table->string('tipo', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('archivos');
        Schema::drop('carpeta_documentos');
        Schema::drop('carpetas');
    }
}
