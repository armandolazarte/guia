<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablasCargos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cargos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->date('inicio');
			$table->date('fin');
		});

		Schema::create('cargo_urg', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('cargo_id')->unsigned();
			$table->foreign('cargo_id')->references('id')->on('cargos');
			$table->integer('urg_id')->unsigned();
			$table->foreign('urg_id')->references('id')->on('urgs');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cargo_urg');
		Schema::drop('cargos');
	}

}
