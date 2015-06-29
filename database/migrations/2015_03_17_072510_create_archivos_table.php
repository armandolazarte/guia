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
        Schema::create('folders', function(Blueprint $table) {
            $table->increments('id');
            $table->string('ruta');
            $table->integer('folder_size')->unsigned();
            $table->boolean('zip');
        });

        Schema::create('folder_docs', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('folder_id')->unsigned();
            $table->integer('doc_id')->unsigned();
            $table->string('doc_type');
        });

        Schema::create('files', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('folder_id')->unsigned();
            $table->integer('doc_id')->unsigned();
            $table->string('doc_type');
            $table->string('name');
            $table->string('mime');
            $table->integer('size')->unsigned();
            $table->string('tipo', 50);
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
        Schema::drop('files');
        Schema::drop('folder_docs');
        Schema::drop('folders');
	}

}
