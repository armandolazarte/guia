<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablasReintegrosHonorarios extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reintegros', function(Blueprint $table)
		{
			$table->increments('id');
			$table->date('fecha');
			$table->decimal('monto', 15, 3);
			$table->integer('origen_id')->unsigned();
			$table->string('origen_type');
		});
		Schema::create('reintegro_rm', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('reintegro_id')->unsigned();
			$table->integer('rm_id')->unsigned();
			$table->decimal('monto', 15, 3);
		});

		Schema::create('reintegro_vale', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('reintegro_id')->unsigned();
			$table->integer('vale_id')->unsigned();
			$table->decimal('monto', 15, 3);
		});

		Schema::create('honorarios', function(Blueprint $table)
		{
			$table->increments('id');
			$table->decimal('monto', 15, 3);
			$table->integer('solreq_id')->unsigned();
			$table->string('solreq_type');
			$table->integer('egreso_id')->unsigned();
			$table->integer('rm_id')->unsigned();
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
		Schema::drop('honorarios');
		Schema::drop('reintegro_vale');
		Schema::drop('reintegro_rm');
		Schema::drop('reintegros');
	}

}
