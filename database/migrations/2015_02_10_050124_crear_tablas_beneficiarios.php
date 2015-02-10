<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablasBeneficiarios extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('benefs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('benef');
			$table->string('tipo', 30);
			$table->string('tel', 100);
			$table->string('correo', 100);
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
		Schema::drop('benefs');
	}

}
