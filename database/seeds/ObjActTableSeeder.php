<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Guia\Models\Objetivo;
use Guia\Models\Actividad;

class ObjActTableSeeder extends Seeder {

    public function run()
    {
        Model::unguard();

        Objetivo::create(array('objetivo' => '1', 'd_objetivo' => ''));
        Actividad::create(array('actividad' => '1', 'd_actividad' => ''));
    }
}