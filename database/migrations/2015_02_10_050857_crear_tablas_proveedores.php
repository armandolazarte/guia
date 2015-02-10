<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablasProveedores extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('proveedores', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('benef_id')->unsigned();
			$table->foreign('benef_id')->references('id')->on('benefs');
			$table->string('nombre_comercial');
			$table->string('rfc', 15);
			$table->string('direccion');
			$table->string('ciudad', 100);
			$table->string('estado', 100);
			$table->string('cp', 6);
			$table->string('tel', 100);
			$table->string('contacto');
			$table->string('representante');
			$table->timestamps();
		});

		Schema::create('giros', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('giro', 50);
		});

		Schema::create('giro_proveedor', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('proveedor_id')->unsigned();
			$table->foreign('proveedor_id')->references('id')->on('proveedores');
			$table->integer('giro_id')->unsigned();
			$table->foreign('giro_id')->references('id')->on('giros');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('giro_proveedor');
		Schema::drop('proveedores');
		Schema::drop('giros');
	}

}
