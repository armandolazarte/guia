<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablasDisponibles extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('disponibles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('fondo_id')->unsigned();
			$table->foreign('fondo_id')->references('id')->on('fondos');
			$table->decimal('monto', 15, 3);
			$table->date('fecha');
			$table->string('obs');
			$table->integer('afin_ejecutora')->unsigned();
			$table->integer('no_t')->unsigned();
			$table->timestamps();
		});

		Schema::create('disponible_proyecto', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('disponible_id')->unsigned();
			$table->foreign('disponible_id')->references('id')->on('disponibles');
			$table->integer('proyecto_id')->unsigned();
			$table->foreign('proyecto_id')->references('id')->on('proyectos');
			$table->decimal('monto', 15, 3);
			$table->integer('no_invoice')->unsigned();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('disponible_proyecto');
		Schema::drop('disponibles');
	}

}
