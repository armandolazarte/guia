<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Guia\Models\Modulo;

class ModulosTableSeeder extends Seeder {

    public function run()
    {
        Model::unguard();

        Modulo::create(array(
            'ruta' => '#',
            'nombre' => 'Administración (SU)',
            'icono' => '',
            'orden' => '100.0',
            'activo' => '0',
        ));
        $modulos = Modulo::create(array(
            'ruta' => '#',
            'nombre' => 'Admin. Modulos',
            'icono' => '',
            'orden' => '100.1',
            'activo' => '1',
        ));
        $modulos->acciones()->attach([1,2,3,4,5,6,7,8,9,10]);
        $adminDb = Modulo::create(array(
            'ruta' => '#',
            'nombre' => 'Base de Datos',
            'icono' => '',
            'orden' => '100.2',
            'activo' => '1',
        ));
        $adminDb->acciones()->attach([11,12]);

        Modulo::create(array(
            'ruta' => '#',
            'nombre' => 'Administración del Sistema',
            'icono' => '',
            'orden' => '99.0',
            'activo' => '0',
        ));

        Modulo::create(array(
            'ruta' => '#',
            'nombre' => 'Usuarios',
            'icono' => '',
            'orden' => '1.0',
            'activo' => '0',
        ));
        Modulo::create(array(
            'ruta' => '#',
            'nombre' => 'Adquisiciones',
            'icono' => '',
            'orden' => '2.0',
            'activo' => '0',
        ));

        Modulo::create(array(
            'ruta' => '#',
            'nombre' => 'Directivos',
            'icono' => '',
            'orden' => '3.0',
            'activo' => '0',
        ));
        Modulo::create(array(
            'ruta' => '#',
            'nombre' => 'Recepción',
            'icono' => '',
            'orden' => '4.0',
            'activo' => '0',
        ));
        Modulo::create(array(
            'ruta' => '#',
            'nombre' => 'Presupuesto',
            'icono' => '',
            'orden' => '5.0',
            'activo' => '0',
        ));
        Modulo::create(array(
            'ruta' => '#',
            'nombre' => 'Contabilidad',
            'icono' => '',
            'orden' => '6.0',
            'activo' => '0',
        ));
        Modulo::create(array(
            'ruta' => '#',
            'nombre' => 'Bancos',
            'icono' => '',
            'orden' => '7.0',
            'activo' => '0',
        ));
        Modulo::create(array(
            'ruta' => '#',
            'nombre' => 'Fondos Externos',
            'icono' => '',
            'orden' => '8.0',
            'activo' => '0',
        ));


    }
}