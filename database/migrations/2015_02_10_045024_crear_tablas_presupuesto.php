<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablasPresupuesto extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('urgs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('urg', 50)->unique();
			$table->string('d_urg');
			$table->string('tel', 100);
			$table->string('domicilio');
			$table->timestamps();
		});

		Schema::create('fondos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('fondo', 50)->unique();
			$table->string('d_fondo');
			$table->string('tipo', 20);
			$table->timestamps();
		});

		Schema::create('tipo_proyectos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('tipo_proyecto', 30);
		});

		Schema::create('proyectos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('proyecto', 100)->unique();
			$table->string('d_proyecto');
			$table->decimal('monto', 15, 3);
			$table->integer('urg_id')->unsigned();
			$table->foreign('urg_id')->references('id')->on('urgs');
			$table->integer('tipo_proyecto_id')->unsigned();
			$table->foreign('tipo_proyecto_id')->references('id')->on('tipo_proyectos');
			$table->smallInteger('aaaa')->unsigned();
			$table->date('inicio');
			$table->date('fin');
			$table->timestamps();
		});

		Schema::create('fondo_proyecto', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('fondo_id')->unsigned();
			$table->foreign('fondo_id')->references('id')->on('fondos');
			$table->integer('proyecto_id')->unsigned();
			$table->foreign('proyecto_id')->references('id')->on('proyectos');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('fondo_proyecto');
		Schema::drop('proyectos');
		Schema::drop('tipo_proyectos');
		Schema::drop('fondos');
		Schema::drop('urgs');
	}

}
