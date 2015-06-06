<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchivosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        $initial_year = env('PRESUPUESTO_INICIAL', '2010');
        $actual_year = \Carbon\Carbon::now()->year;

        for($i = $initial_year; $i <= $actual_year; $i++){
            Schema::connection('archivo_'.$i)->create('archivos', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('linkable_id')->unsigned();
                $table->string('linkable_type');
                $table->string('name');
                $table->string('mime');
                $table->integer('size')->unsigned();
                $table->dateTime('created_original');
                $table->string('extension', 4);
                $table->string('tipo');
                $table->timestamps();
            });

            Schema::connection('archivo_'.$i)->create('data_files', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('archivo_id')->unsigned();
                $table->integer('chunk_id')->unsigned();
                $table->binary('data');
            });
        }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        $initial_year = env('PRESUPUESTO_INICIAL', '2010');
        $actual_year = \Carbon\Carbon::now()->year;

        for($i = $initial_year; $i <= $actual_year; $i++) {
            Schema::connection('archivo_'.$i)->drop('data_files');
            Schema::connection('archivo_'.$i)->drop('archivos');
        }
	}

}
