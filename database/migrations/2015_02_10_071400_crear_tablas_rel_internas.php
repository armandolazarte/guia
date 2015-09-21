<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablasRelInternas extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rel_internas', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha_envio');
            $table->date('fecha_revision');
            $table->smallInteger('envia')->unsigned();
            $table->smallInteger('recibe')->unsigned();
            $table->string('estatus', 12);
            $table->string('tipo_documentos', 20);
            $table->timestamps();
        });

        Schema::create('rel_interna_docs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rel_interna_id')->unsigned();
            $table->foreign('rel_interna_id')->references('id')->on('rel_internas')->onDelete('cascade');
            $table->string('validacion', 12);
            $table->integer('docable_id')->unsigned();
            $table->string('docable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rel_interna_docs');
        Schema::drop('rel_internas');
    }

}
