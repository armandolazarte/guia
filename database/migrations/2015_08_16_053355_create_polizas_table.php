<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePolizasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polizas', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->string('tipo', 45);
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('poliza_cargos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('poliza_id')->unsigned();
            $table->foreign('poliza_id')->references('id')->on('polizas')->onDelete('cascade');
            $table->integer('cuenta_id')->unsigned();
            $table->foreign('cuenta_id')->references('id')->on('cuentas');
            $table->decimal('monto', 15, 3);
            $table->integer('origen_id')->unsigned();
            $table->string('origen_type');
        });

        Schema::create('poliza_abonos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('poliza_id')->unsigned();
            $table->foreign('poliza_id')->references('id')->on('polizas')->onDelete('cascade');
            $table->integer('cuenta_id')->unsigned();
            $table->foreign('cuenta_id')->references('id')->on('cuentas');
            $table->decimal('monto', 15, 3);
            $table->integer('origen_id')->unsigned();
            $table->string('origen_type');
        });

        Schema::create('poliza_cargo_rm', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('poliza_cargo_id')->unsigned();
            $table->foreign('poliza_cargo_id')->references('id')->on('poliza_cargos')->onDelete('cascade');
            $table->integer('rm_id')->unsigned();
            $table->foreign('rm_id')->references('id')->on('rms');
            $table->decimal('monto', 15, 3);
        });

        Schema::create('poliza_abono_rm', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('poliza_abono_id')->unsigned();
            $table->foreign('poliza_abono_id')->references('id')->on('poliza_abonos')->onDelete('cascade');
            $table->integer('rm_id')->unsigned();
            $table->foreign('rm_id')->references('id')->on('rms');
            $table->decimal('monto', 15, 3);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('poliza_abono_rm');
        Schema::drop('poliza_cargo_rm');
        Schema::drop('poliza_abonos');
        Schema::drop('poliza_cargos');
        Schema::drop('polizas');
    }
}
