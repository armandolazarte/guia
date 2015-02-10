<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablasBancos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cuentas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->smallInteger('cuenta')->unsigned()->unique();
			$table->string('d_cuenta');
			$table->string('no_cuenta');
			$table->string('banco');
			$table->string('tipo', 50);
			$table->boolean('activa');
			$table->integer('urg_id')->unsigned();
			$table->foreign('urg_id')->references('id')->on('urgs');
			$table->timestamps();
		});

		//Relación entre Cuentas Bancarias y Proyectos para FEXT
		Schema::create('cuenta_proyecto', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('cuenta_id')->unsigned();
			$table->foreign('cuenta_id')->references('id')->on('cuentas');
			$table->integer('proyecto_id')->unsigned();
			$table->foreign('proyecto_id')->references('id')->on('proyectos');
		});

		Schema::create('conceptos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('concepto', 100);
			$table->string('tipo', 20);
		});

		Schema::create('egresos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('cuenta_id')->unsigned();
			$table->foreign('cuenta_id')->references('id')->on('cuentas');
			$table->integer('poliza')->unsigned();
			$table->date('fecha');
			$table->integer('benef_id')->unsigned();
			$table->foreign('benef_id')->references('id')->on('benefs');
			$table->integer('concepto_id')->unsigned();
			$table->foreign('concepto_id')->references('id')->on('conceptos');
			$table->string('cmt');
			$table->decimal('monto', 15, 3);
			$table->string('estatus', 30);
			$table->smallInteger('responsable')->unsigned();
			$table->date('fecha_cobro');
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('ingresos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('cuenta_id')->unsigned();
			$table->foreign('cuenta_id')->references('id')->on('cuentas');
			$table->integer('poliza')->unsigned();
			$table->date('fecha');
			$table->integer('concepto_id')->unsigned();
			$table->foreign('concepto_id')->references('id')->on('conceptos');
			$table->string('cmt');
			$table->decimal('monto', 15, 3);
			$table->date('fecha_identifica');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ingresos');
		Schema::drop('egresos');
		Schema::drop('conceptos');
		Schema::drop('cuenta_proyecto');
		Schema::drop('cuentas');
	}

}
