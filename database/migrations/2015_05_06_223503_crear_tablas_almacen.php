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
            $table->integer('user_id')->unsigned();
			$table->timestamps();
		});

        Schema::create('articulo_entrada', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('entrada_id')->unsigned();
            $table->integer('articulo_id')->unsigned();
            $table->string('articulo_type');
            $table->decimal('cantidad', 15, 3)->unsigned();
            $table->decimal('costo', 15, 3)->unsigned();
            $table->tinyInteger('impuesto')->unsigned;
        });

        Schema::create('salidas', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('entrada_id')->unsigned();
            $table->date('fecha_salida');
            $table->integer('urg_id')->unsigned();
            $table->text('cmt');
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });

        Schema::create('articulo_salida', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('salida_id')->unsigned();
            $table->integer('articulo_id')->unsigned();
            $table->string('articulo_type');
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
        Schema::drop('articulo_salida');
        Schema::drop('salidas');
        Schema::drop('articulo_entrada');
		Schema::drop('entradas');
        Schema::drop('noreq_articulos');
	}

}
