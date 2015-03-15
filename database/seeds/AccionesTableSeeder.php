<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Guia\Models\Accion;

class AccionesTableSeeder extends Seeder {

    public function run()
    {
        Model::unguard();

        Accion::create(array(
            'ruta' => '/admin/su/modulos',
            'nombre' => 'Modulos',
            'icono' => '',
            'orden' => '100.1.1',
            'activo' => '1',
        ));
        Accion::create(array(
            'ruta' => '/admin/su/modulos/crear',
            'nombre' => '',
            'icono' => '',
            'orden' => '',
            'activo' => '0',
        ));
        Accion::create(array(
            'ruta' => '/admin/su/modulos/{modulo}/editar',
            'nombre' => '',
            'icono' => '',
            'orden' => '',
            'activo' => '0',
        ));
        Accion::create(array(
            'ruta' => '/admin/su/modulos/{modulo}',
            'nombre' => '',
            'icono' => '',
            'orden' => '',
            'activo' => '0',
        ));

        Accion::create(array(
            'ruta' => '/admin/su/acciones',
            'nombre' => 'Acciones',
            'icono' => '',
            'orden' => '100.1.2',
            'activo' => '1',
        ));
        Accion::create(array(
            'ruta' => '/admin/su/acciones/rutas',
            'nombre' => '',
            'icono' => '',
            'orden' => '',
            'activo' => '0',
        ));
        Accion::create(array(
            'ruta' => '/admin/su/acciones/{accion}/editar',
            'nombre' => '',
            'icono' => '',
            'orden' => '',
            'activo' => '0',
        ));
        Accion::create(array(
            'ruta' => '/admin/su/acciones/{accion}',
            'nombre' => '',
            'icono' => '',
            'orden' => '',
            'activo' => '0',
        ));

        Accion::create(array(
            'ruta' => '/admin/su/importar-catalogos',
            'nombre' => 'Importar Catálogos',
            'icono' => '',
            'orden' => '100.2.1',
            'activo' => '1',
        ));
    }
}