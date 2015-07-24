<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddScopeToAccionModuloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accion_modulo', function (Blueprint $table) {
            $table->string('scope');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accion_modulo', function (Blueprint $table) {
            $table->dropColumn('scope');
        });
    }
}
