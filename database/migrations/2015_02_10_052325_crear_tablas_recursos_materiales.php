<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablasRecursosMateriales extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('actividades', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('actividad')->unsigned();
			$table->text('d_actividad');
		});

		Schema::create('objetivos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('objetivo')->unsigned();
			$table->text('d_objetivo');
		});

		Schema::create('rms', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('rm');
			$table->integer('proyecto_id')->unsigned();
			$table->foreign('proyecto_id')->references('id')->on('proyectos');
			$table->integer('objetivo_id')->unsigned();
			$table->integer('actividad_id')->unsigned();
			$table->integer('cog_id')->unsigned();
			$table->foreign('cog_id')->references('id')->on('cogs');
			$table->integer('fondo_id')->unsigned();
			$table->foreign('fondo_id')->references('id')->on('fondos');
			$table->decimal('monto', 15, 3);
			$table->text('d_rm');
			$table->timestamps();
		});

		Schema::create('bms_rms', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('rm_id')->unsigned();
			$table->string('bms', 50);
		});

		Schema::create('ingreso_rm', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('ingreso_id')->unsigned();
			$table->integer('rm_id')->unsigned();
			$table->decimal('monto', 15, 3);
			$table->timestamps();
		});

		Schema::create('egreso_rm', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('egreso_id')->unsigned();
			$table->integer('rm_id')->unsigned();
			$table->decimal('monto', 15, 3);
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
		Schema::drop('egreso_rm');
		Schema::drop('ingreso_rm');
		Schema::drop('bms_rms');
		Schema::drop('rms');
		Schema::drop('objetivos');
		Schema::drop('actividades');
	}

}
