<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablasFacturas extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('facturas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('rfc', 15);
			$table->string('serie', 50);
			$table->string('factura');
			$table->date('fecha');
			$table->decimal('subtotal', 15, 3);
			$table->decimal('iva', 15, 3);
			$table->decimal('total', 15, 3);
			$table->boolean('cfd');
			$table->timestamps();
		});

		Schema::create('factura_conceptos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('factura_id')->unsigned();
			$table->foreign('factura_id')->references('id')->on('facturas')->onDelete('cascade');
			$table->mediumInteger('cantidad')->unsigned();
			$table->string('concepto');
			$table->integer('rm_id')->unsigned();
			$table->foreign('rm_id')->references('id')->on('rms');
			$table->integer('cog_id')->unsigned();
			$table->foreign('cog_id')->references('id')->on('cogs');
			$table->boolean('inventariable');
			$table->decimal('monto', 15, 3);
		});

		/**
		 * Factura Tipo de Cambio
		 *
		 */
		Schema::create('fact_tcs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('factura_id')->unsigned();
			$table->foreign('factura_id')->references('id')->on('facturas')->onDelete('cascade');
			$table->decimal('tc', 9, 6);
			$table->string('moneda', 5);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('fact_tcs');
		Schema::drop('factura_conceptos');
		Schema::drop('facturas');
	}

}
