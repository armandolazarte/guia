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
        Modulo::create(['ruta' => '#', 'nombre' => 'Solicitudes', 'icono' => '', 'orden' => '1.1', 'activo' => '1']);
        Modulo::create(['ruta' => '#', 'nombre' => 'Requisiciones', 'icono' => '', 'orden' => '1.2', 'activo' => '1']);

        Modulo::create(array(
            'ruta' => '#',
            'nombre' => 'Adquisiciones',
            'icono' => '',
            'orden' => '2.0',
            'activo' => '0',
        ));
        Modulo::create(['ruta' => '#', 'nombre' => 'Requisiciones', 'icono' => '', 'orden' => '2.1', 'activo' => '1']);
        Modulo::create(['ruta' => '#', 'nombre' => 'Invitaciones', 'icono' => '', 'orden' => '2.2', 'activo' => '0']);
        Modulo::create(['ruta' => '#', 'nombre' => 'Cuadros Comparativos', 'icono' => '', 'orden' => '2.3', 'activo' => '0']);
        Modulo::create(['ruta' => '#', 'nombre' => 'Ordenes de compra', 'icono' => '', 'orden' => '2.3', 'activo' => '0']);

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
        Modulo::create(['ruta' => '#', 'nombre' => 'Cheques', 'icono' => '', 'orden' => '4.1', 'activo' => '1']);
        Modulo::create(['ruta' => '#', 'nombre' => 'Solicitudes', 'icono' => '', 'orden' => '4.2', 'activo' => '1']);

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

        Modulo::create(array(
            'ruta' => '#',
            'nombre' => 'URG',
            'icono' => '',
            'orden' => '9.0',
            'activo' => '0',
        ));
        Modulo::create(['ruta' => '#', 'nombre' => 'Solicitudes (PreReq)', 'icono' => '', 'orden' => '9.1', 'activo' => '1']);
        Modulo::create(['ruta' => '#', 'nombre' => 'Requisiciones', 'icono' => '', 'orden' => '9.2', 'activo' => '1']);

        Modulo::create(array(
            'ruta' => '#',
            'nombre' => 'Usuario',
            'icono' => '',
            'orden' => '10.0',
            'activo' => '0',
        ));
        Modulo::create(['ruta' => '#', 'nombre' => 'Solicitudes (PreReq)', 'icono' => '', 'orden' => '10.1', 'activo' => '1']);

        Modulo::create(array(
            'ruta' => '#',
            'nombre' => 'Almacén',
            'icono' => '',
            'orden' => '11.0',
            'activo' => '0',
        ));
        Modulo::create(['ruta' => '#', 'nombre' => 'Entradas', 'icono' => '', 'orden' => '11.1', 'activo' => '1']);
        Modulo::create(['ruta' => '#', 'nombre' => 'Salidas', 'icono' => '', 'orden' => '11.2', 'activo' => '1']);
        Modulo::create(['ruta' => '#', 'nombre' => 'Reportes', 'icono' => '', 'orden' => '11.3', 'activo' => '1']);
    }
}