<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablasPreRequisicion extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pre_reqs', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('sol')->unsigned()->unique();
            $table->date('fecha');
            $table->integer('urg_id')->unsigned();
            $table->foreign('urg_id')->references('id')->on('urgs');
            $table->string('etiqueta', 100);
            $table->string('lugar_entrega');
            $table->text('obs');
            $table->integer('user_id')->unsigned();//Solicita
            $table->foreign('user_id')->references('id')->on('users');
            $table->text('justifica');
            $table->text('grado', 5);
            $table->string('usuario_final');
            $table->string('estatus', 20);
            $table->string('tipo_orden', 20);
		});

        Schema::create('pre_req_articulos', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('pre_req_id')->unsigned();
            $table->foreign('pre_req_id')->references('id')->on('pre_reqs');
            $table->text('articulo');
            $table->double('cantidad', 12, 5);
            $table->string('unidad', 20);
            $table->integer('req_id')->unsigned();
            $table->string('motivo_rechazo');
            $table->date('fecha_revision');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('pre_req_articulos');
		Schema::drop('pre_reqs');
	}

}
