<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDestinoToRelInternasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rel_internas', function (Blueprint $table) {
            $table->integer('destino_id')->unsigned()->after('tipo_documentos');
            $table->string('destino_type')->after('destino_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rel_internas', function (Blueprint $table) {
            $table->dropColumn('destino_type');
            $table->dropColumn('destino_id');
        });
    }
}
