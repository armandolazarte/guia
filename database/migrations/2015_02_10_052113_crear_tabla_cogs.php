<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaCogs extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cogs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('tipo_proyecto_id')->unsigned();
			$table->foreign('tipo_proyecto_id')->references('id')->on('tipo_proyectos');
			$table->string('cog');
			$table->string('d_cog');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cogs');
	}

}
