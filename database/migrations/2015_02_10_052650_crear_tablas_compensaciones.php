<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablasCompensaciones extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('compensa_rms', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('documento_afin')->unsigned();
			$table->date('fecha');
			$table->string('tipo', 20);
			$table->timestamps();
		});

		Schema::create('compensa_origenes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('compensa_rm_id')->unsigned();
			$table->foreign('compensa_rm_id')->references('id')->on('compensa_rms');
			$table->integer('rm_id')->unsigned();
			$table->foreign('rm_id')->references('id')->on('rms');
			$table->decimal('monto', 15, 3);
			$table->timestamps();
		});

		Schema::create('compensa_destinos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('compensa_rm_id')->unsigned();
			$table->foreign('compensa_rm_id')->references('id')->on('compensa_rms');
			$table->integer('rm_id')->unsigned();
			$table->foreign('rm_id')->references('id')->on('rms');
			$table->decimal('monto', 15, 3);
			$table->timestamps();
		});

		Schema::create('urg_externas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('urg_externa', 50);
			$table->string('d_urg_externa');
		});

		Schema::create('compensa_externas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('compensa_rm_id')->unsigned();
			$table->foreign('compensa_rm_id')->references('id')->on('compensa_rms');
			$table->integer('urg_externa_id')->unsigned();
			$table->foreign('urg_externa_id')->references('id')->on('urg_externas');
			$table->string('concepto');
			$table->string('tipo', 20);
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
		Schema::drop('compensa_externas');
		Schema::drop('urg_externas');
		Schema::drop('compensa_destinos');
		Schema::drop('compensa_origenes');
		Schema::drop('compensa_rms');
	}

}
