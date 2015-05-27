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
            $table->integer('proyecto_id')->unsigned();
            $table->foreign('proyecto_id')->references('id')->on('proyectos');
            $table->string('etiqueta', 100);
            $table->string('lugar_entrega');
            $table->text('obs');
            $table->smallInteger('solicita')->unsigned();
            $table->text('justifica');
            $table->smallInteger('grado')->unsigned();
            $table->string('estatus', 20);
            $table->integer('user_id')->unsigned();//Responsable
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('tipo_orden', 20);
		});

        Schema::create('pre_reqs_articulos', function(Blueprint $table)
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
        Schema::drop('pre_reqs_articulos');
		Schema::drop('pre_reqs');
	}

}
