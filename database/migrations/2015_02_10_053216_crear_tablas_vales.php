<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablasVales extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vales', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('egreso_id')->unsigned();
			$table->foreign('egreso_id')->references('id')->on('egresos');
			$table->integer('proyecto_id')->unsigned();
			$table->foreign('proyecto_id')->references('id')->on('proyectos');
			$table->string('cmt');
			$table->date('fecha_comp');
			$table->string('estatus', 20);
			$table->decimal('monto', 15, 3);
			$table->timestamps();
		});

		Schema::create('rm_vale', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('vale_id')->unsigned();
			$table->integer('rm_id')->unsigned();
			$table->decimal('monto', 15, 3);
		});

		Schema::create('objetivo_vale', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('vale_id')->unsigned();
			$table->integer('objetivo_id')->unsigned();
			$table->decimal('monto', 15, 3);
		});

		Schema::create('factura_vale', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('vale_id')->unsigned();
			$table->integer('factura_id')->unsigned();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('factura_vale');
		Schema::drop('objetivo_vale');
		Schema::drop('rm_vale');
		Schema::drop('vales');
	}

}
