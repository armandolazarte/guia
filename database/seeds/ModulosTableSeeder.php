<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Guia\Models\Modulo;

class ModulosTableSeeder extends Seeder {

    public function run()
    {
        Model::unguard();

        Modulo::create(array(
            'ruta' => '/usuarios',
            'nombre' => 'Usuarios',
            'icono' => '',
            'orden' => '0.1',
            'activo' => '1',
        ));
        Modulo::create(array(
            'ruta' => '/adq',
            'nombre' => 'Adquisiciones',
            'icono' => '',
            'orden' => '0.2',
            'activo' => '1',
        ));

        Modulo::create(array(
            'ruta' => '/directivos',
            'nombre' => 'Directivos',
            'icono' => '',
            'orden' => '0.3',
            'activo' => '1',
        ));
        Modulo::create(array(
            'ruta' => '/recepcion',
            'nombre' => 'Recepción',
            'icono' => '',
            'orden' => '0.4',
            'activo' => '1',
        ));
        Modulo::create(array(
            'ruta' => '/presupuesto',
            'nombre' => 'Presupuesto',
            'icono' => '',
            'orden' => '0.5',
            'activo' => '1',
        ));
        Modulo::create(array(
            'ruta' => '/contabilidad',
            'nombre' => 'Contabilidad',
            'icono' => '',
            'orden' => '0.6',
            'activo' => '1',
        ));
        Modulo::create(array(
            'ruta' => '/bancos',
            'nombre' => 'Bancos',
            'icono' => '',
            'orden' => '0.7',
            'activo' => '1',
        ));
        Modulo::create(array(
            'ruta' => '/fext',
            'nombre' => 'Fondos Externos',
            'icono' => '',
            'orden' => '0.8',
            'activo' => '1',
        ));
    }
}