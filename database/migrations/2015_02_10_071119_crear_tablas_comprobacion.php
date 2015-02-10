<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablasComprobacion extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comps', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('oficio_c', 50);
			$table->string('comp_siiau', 20);
			$table->string('estatus', 20);
			$table->smallInteger('responsable')->unsigned();
			$table->smallInteger('elabora')->unsigned();
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('comp_egreso', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('comp_id')->unsigned();
			$table->integer('egreso_id')->unsigned();
		});

		Schema::create('comp_factura', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('comp_id')->unsigned();
			$table->integer('factura_id')->unsigned();
		});

		Schema::create('paquetes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('estatus', 20);
			$table->smallInteger('elabora')->unsigned();
			$table->date('fecha_elabora');
			$table->date('fecha_recibido');
			$table->timestamps();
		});

		Schema::create('comp_paquete', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('paquete_id')->unsigned();
			$table->integer('comp_id')->unsigned();
		});

		Schema::create('comp_devs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('comp_id')->unsigned();
			$table->date('fecha_envio');
			$table->date('fecha_dev');
			$table->string('motivo');
			$table->timestamps();
		});

		Schema::create('comp_devs_rms', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('comp_dev_id')->unsigned();
			$table->integer('egreso_id')->unsigned();
			$table->integer('rm_id')->unsigned();
			$table->decimal('monto_c', 15, 3);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('comp_devs_rms');
		Schema::drop('comp_devs');
		Schema::drop('comp_paquete');
		Schema::drop('paquetes');
		Schema::drop('comp_factura');
		Schema::drop('comp_egreso');
		Schema::drop('comps');
	}

}
