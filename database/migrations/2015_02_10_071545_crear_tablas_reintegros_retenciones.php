<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablasReintegrosRetenciones extends Migration {

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
            $table->integer('egreso_id')->unsigned();
            $table->foreign('egreso_id')->references('id')->on('egresos');
			$table->date('fecha');
            $table->decimal('monto', 15, 3);
		});

		Schema::create('reintegro_rm', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('reintegro_id')->unsigned();
            $table->foreign('reintegro_id')->references('id')->on('reintegros');
			$table->integer('rm_id')->unsigned();
			$table->decimal('monto', 15, 3);
		});

		Schema::create('objetivo_reintegro', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('reintegro_id')->unsigned();
            $table->foreign('reintegro_id')->references('id')->on('reintegros');
			$table->integer('objetivo_id')->unsigned();
			$table->decimal('monto', 15, 3);
		});

		Schema::create('retenciones', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('doc_id')->unsigned();
			$table->string('doc_type');
            $table->integer('rm_id')->unsigned();
            $table->foreign('rm_id')->references('id')->on('rms');
            $table->string('tipo_retencion', 20);
            $table->decimal('monto', 15, 3);
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('retenciones');
		Schema::drop('objetivo_reintegro');
		Schema::drop('reintegro_rm');
		Schema::drop('reintegros');
	}

}
