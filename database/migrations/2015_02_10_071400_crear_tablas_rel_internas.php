<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablasRelInternas extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rel_internas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->date('fecha_envio');
			$table->date('fecha_revision');
			$table->smallInteger('envia')->unsigned();
			$table->smallInteger('recibe')->unsigned();
			$table->string('status', 12);
			$table->timestamps();
		});

		Schema::create('rel_interna_docs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('rel_interna_id')->unsigned();
			$table->string('validacion', 12);
			$table->integer('docable_id')->unsigned();
			$table->string('docable_type');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('rel_interna_docs');
		Schema::drop('rel_internas');
	}

}
