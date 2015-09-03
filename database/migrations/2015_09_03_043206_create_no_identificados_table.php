<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoIdentificadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('no_identificados', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cuenta_bancaria_id')->unsigned();
            $table->foreign('cuenta_bancaria_id')->references('id')->on('cuentas_bancarias');
            $table->date('fecha');
            $table->decimal('monto', 12, 3);
            $table->string('no_deposito');
            $table->boolean('identificado');
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
        Schema::drop('no_identificados');
    }
}
