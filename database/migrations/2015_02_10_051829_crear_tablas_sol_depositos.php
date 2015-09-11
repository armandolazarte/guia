<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablasSolDepositos extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sol_depositos', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha_deposito');
            $table->string('estatus', 20);
            $table->integer('fondo_id')->unsigned();
            $table->foreign('fondo_id')->references('id')->on('fondos');
            $table->integer('afin_soldep')->unsigned();
            $table->integer('t_banco')->unsigned();
            $table->string('obs');
            $table->integer('ingreso_id')->unsigned();
            $table->timestamps();
        });

        Schema::create('sol_depositos_docs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sol_deposito_id')->unsigned();
            $table->foreign('sol_deposito_id')->references('id')->on('sol_depositos')->onDelete('cascade');
            $table->integer('doc_id')->unsigned();
            $table->string('doc_type');
            $table->decimal('monto', 15, 3);
            $table->decimal('monto_retencion', 15, 3);
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
        Schema::drop('sol_depositos_docs');
        Schema::drop('sol_depositos');
    }

}
