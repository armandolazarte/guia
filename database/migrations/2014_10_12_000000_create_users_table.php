<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');

            $table->string('username', 20)->unique();
            $table->string('email');
            $table->string('password', 60);
            $table->string('legacy_username', 20);

            $table->string('nombre');
            $table->string('cargo');
            $table->string('prefijo', 50);
            $table->string('iniciales', 5);
            $table->integer('adscripcion')->unsigned();

            $table->boolean('active');
            $table->boolean('validated');

            $table->rememberToken();
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
        Schema::drop('users');
    }
}
