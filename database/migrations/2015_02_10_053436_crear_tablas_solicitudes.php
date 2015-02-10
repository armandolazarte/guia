<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablasSolicitudes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('solicitudes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->date('fecha');
			$table->integer('benef_id')->unsigned();
			$table->foreign('benef_id')->references('id')->on('benefs');
			$table->string('tipo_solicitud', 20);
			$table->integer('urg_id')->unsigned();
			$table->foreign('urg_id')->references('id')->on('urgs');
			$table->integer('proyecto_id')->unsigned();
			$table->foreign('proyecto_id')->references('id')->on('proyectos');
			$table->text('concepto');
			$table->text('obs');
			$table->string('no_documento', 50);
			$table->integer('no_afin')->unsigned();
			$table->decimal('monto', 15, 3);
			$table->smallInteger('solicita')->unsigned();
			$table->smallInteger('autoriza')->unsigned();
			$table->smallInteger('vobo')->unsigned();
			$table->string('estatus', 20);
			$table->smallInteger('responsable')->unsigned();
			$table->decimal('monto_pagado', 15, 3);
			$table->boolean('viaticos');
			$table->date('fecha_recibido');
			$table->boolean('inventariable');
			$table->timestamps();
		});

		Schema::create('solicitudes_devs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('solicitud_id')->unsigned();
			$table->foreign('solicitud_id')->references('id')->on('solicitudes');
			$table->string('no_oficio', 50);
			$table->date('fecha');
			$table->smallInteger('elabora')->unsigned();
			$table->text('obs');
			$table->date('recibido_cfin');
			$table->date('recibido_urg');
			$table->timestamps();
		});

		Schema::create('factura_solicitud', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('solicitud_id')->unsigned();
			$table->integer('factura_id')->unsigned();
		});

		Schema::create('rm_solicitud', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('solicitud_id')->unsigned();
			$table->integer('rm_id')->unsigned();
			$table->decimal('monto', 15, 3);
		});

		Schema::create('objetivo_solicitud', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('solicitud_id')->unsigned();
			$table->integer('objetivo_id')->unsigned();
			$table->decimal('monto', 15, 3);
		});

		Schema::create('egreso_solicitud', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('solicitud_id')->unsigned();
			$table->integer('egreso_id')->unsigned();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('egreso_solicitud');
		Schema::drop('objetivo_solicitud');
		Schema::drop('rm_solicitud');
		Schema::drop('factura_solicitud');
		Schema::drop('solicitudes_devs');
		Schema::drop('solicitudes');
	}

}
