<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Guia\Models\Accion;

class AccionesTableSeeder extends Seeder {

    public function run()
    {
        Model::unguard();

        Accion::create(['ruta' => 'ModuloController@index', 'nombre' => 'Modulos', 'icono' => '', 'orden' => '100.1.1', 'activo' => '1']);
        Accion::create(['ruta' => 'ModuloController@create', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'ModuloController@store', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'ModuloController@edit', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'ModuloController@update', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);

        Accion::create(['ruta' => 'AccionesController@index', 'nombre' => 'Acciones', 'icono' => '', 'orden' => '100.1.2', 'activo' => '1']);
        Accion::create(['ruta' => 'AccionesController@create', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'AccionesController@store', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'AccionesController@edit', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'AccionesController@update', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);

        Accion::create(['ruta' => 'ImportaCatalogosController@index', 'nombre' => 'Importar Catálogos', 'icono' => '', 'orden' => '100.2.1', 'activo' => '1']);
        Accion::create(['ruta' => 'ImportaCatalogosController@importar', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
    }
}