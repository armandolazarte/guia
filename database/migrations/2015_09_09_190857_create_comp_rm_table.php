<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompRmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comp_rm', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('comp_id')->unsigned();
            $table->foreign('comp_id')->references('id')->on('comps')->onDelete('cascade');
            $table->integer('rm_id')->unsigned();
            $table->foreign('rm_id')->references('id')->on('rms');
            $table->decimal('monto', 15, 3);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('comp_rm');
    }
}
