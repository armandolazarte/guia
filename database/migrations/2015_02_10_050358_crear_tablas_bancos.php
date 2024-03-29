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
		Schema::create('cuentas_bancarias', function(Blueprint $table)
		{
			$table->increments('id');
			$table->smallInteger('cuenta_bancaria')->unsigned()->unique();
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
		Schema::create('cuenta_bancaria_proyecto', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('cuenta_bancaria_id')->unsigned();
			$table->foreign('cuenta_bancaria_id')->references('id')->on('cuentas_bancarias');
			$table->integer('proyecto_id')->unsigned();
			$table->foreign('proyecto_id')->references('id')->on('proyectos');
		});

		Schema::create('cuentas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('cuenta', 100);
			$table->string('tipo', 20);
		});

		Schema::create('egresos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('cuenta_bancaria_id')->unsigned();
			$table->foreign('cuenta_bancaria_id')->references('id')->on('cuentas_bancarias');
			$table->integer('poliza')->unsigned();
            $table->integer('cheque')->unsigned();
			$table->date('fecha');
			$table->integer('benef_id')->unsigned();
			$table->foreign('benef_id')->references('id')->on('benefs');
			$table->integer('cuenta_id')->unsigned();
			$table->foreign('cuenta_id')->references('id')->on('cuentas');
			$table->string('concepto');
			$table->decimal('monto', 15, 3);
			$table->string('estatus', 30);
			$table->integer('user_id')->unsigned();
			$table->date('fecha_cobro');
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('ingresos', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('cuenta_bancaria_id')->unsigned();
            $table->foreign('cuenta_bancaria_id')->references('id')->on('cuentas_bancarias');
			$table->integer('poliza')->unsigned();
			$table->date('fecha');
            $table->integer('cuenta_id')->unsigned();
            $table->foreign('cuenta_id')->references('id')->on('cuentas');
			$table->string('concepto');
			$table->decimal('monto', 15, 3);
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
		Schema::drop('cuentas');
		Schema::drop('cuenta_bancaria_proyecto');
		Schema::drop('cuentas_bancarias');
	}

}
