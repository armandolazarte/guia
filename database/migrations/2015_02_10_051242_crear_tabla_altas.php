<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaAltas extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('altas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('doc_id');
			$table->string('tipo', 20);
			$table->integer('egreso_id')->unsigned();
			//$table->foreign('egreso_id')->references('id')->on('egresos');
			$table->integer('urg_id')->unsigned();
			$table->foreign('urg_id')->references('id')->on('urgs');
			$table->integer('debito')->unsigned();
			$table->string('estatus', 20);
			$table->smallInteger('usr_id')->unsigned();
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
		Schema::drop('altas');
	}

}
