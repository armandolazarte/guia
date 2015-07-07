<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Guia\Models\TipoProyecto;

class TipoProyectosTableSeeder extends Seeder {

    public function run()
    {
        Model::unguard();

        TipoProyecto::create(array('tipo_proyecto' => 'P3E-LGCG'));
        TipoProyecto::create(array('tipo_proyecto' => 'P3E 2011 y Anteriores'));
        TipoProyecto::create(array('tipo_proyecto' => 'Fondos Externos'));
    }
}