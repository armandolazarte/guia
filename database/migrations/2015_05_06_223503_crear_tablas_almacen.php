<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablasAlmacen extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('noreq_articulos', function(Blueprint $table)
        {
            $table->increments('id');
            $table->text('articulo');
            $table->string('unidad', 20);
        });

		Schema::create('entradas', function(Blueprint $table)
		{
			$table->increments('id');
            $table->date('fecha_entrada');
            $table->integer('ref')->unsigned();
            $table->string('ref_tipo', 10);
            $table->date('ref_fecha');
            $table->integer('urg_id')->unsigned();
            $table->integer('benef_id')->unsigned();
            $table->text('cmt');
            $table->smallInteger('responsable')->unsigned();
			$table->timestamps();
		});

        Schema::create('entrada_articulos', function(Blueprint $table)
        {
            $table->integer('entrada_id')->unsigned();
            $table->integer('entrada_articulo_id')->unsigned();
            $table->string('entrada_articulo_type');
            $table->decimal('cantidad', 15, 3)->unsigned();
        });

        Schema::create('salidas', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('entrada_id')->unsigned();
            $table->date('fecha_salida');
            $table->integer('urg_id')->unsigned();
            $table->text('cmt');
            $table->smallInteger('responsable')->unsigned();
            $table->timestamps();
        });

        Schema::create('salida_articulos', function(Blueprint $table)
        {
            $table->integer('salida_id')->unsigned();
            $table->integer('salida_articulo_id')->unsigned();
            $table->string('salida_articulo_type');
            $table->decimal('cantidad', 15, 3)->unsigned();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('salida_articulos');
        Schema::drop('salidas');
        Schema::drop('entrada_articulos');
		Schema::drop('entradas');
        Schema::drop('noreq_articulos');
	}

}
