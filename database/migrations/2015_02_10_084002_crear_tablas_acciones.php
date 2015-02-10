<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablasAcciones extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('acciones', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('ruta');
			$table->string('nombre', 100);
			$table->string('icono', 50);
			$table->string('orden', 12);
			$table->boolean('activo');
		});

		Schema::create('accion_modulo', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('modulo_id')->unsigned();
			$table->integer('accion_id')->unsigned();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('accion_modulo');
		Schema::drop('acciones');
	}

}
