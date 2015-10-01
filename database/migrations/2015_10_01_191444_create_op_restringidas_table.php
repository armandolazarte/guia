<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpRestringidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('op_restringidas', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('aaaa')->unsigned();
            $table->string('modelo');
            $table->string('motivo');
            $table->string('mensaje');
            $table->date('inicio');
            $table->date('fin');
            $table->integer('aplica_id')->unsigned();
            $table->string('aplica_type');
        });

        Schema::create('op_excepciones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('op_restringida_id')->unsigned();
            $table->foreign('op_restringida_id')->references('id')->on('op_restringidas')->onDelete('cascade');
            $table->date('inicio');
            $table->date('fin');
            $table->integer('aplica_id')->unsigned();
            $table->string('aplica_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('op_excepciones');
        Schema::drop('op_restringidas');
    }
}
