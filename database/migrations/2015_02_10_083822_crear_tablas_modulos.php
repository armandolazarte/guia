<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablasModulos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('modulos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('ruta');
			$table->string('nombre', 100);
			$table->string('icono', 50);
			$table->string('orden', 12);
			$table->boolean('activo');
		});

		Schema::create('modulo_role', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('modulo_id')->unsigned();
			$table->integer('role_id')->unsigned();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('modulo_role');
		Schema::drop('modulos');
	}

}
