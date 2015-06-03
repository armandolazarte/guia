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

        //-- Administración Tipos de Proyectos --//
        Accion::create(['ruta' => 'TiposProyectosController@index', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'TiposProyectosController@create', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'TiposProyectosController@edit', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'TiposProyectosController@store', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'TiposProyectosController@update', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);

        //-- Proyectos --//
        Accion::create(['ruta' => 'ProyectosController@index', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'ImportarProyectoController@index', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'ImportarProyectoController@postUpload', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'ImportarProyectoController@convertir', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'ImportarProyectoController@show', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'ImportarProyectoController@store', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);

        //-- Recibir Requisiciones --//
        Accion::create(['ruta' => 'RecibirController@seleccionarReq', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'RecibirController@recibirReq', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);

        //-- Requisiciones --//
        Accion::create(['ruta' => 'RequisicionController@index', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'RequisicionController@create', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'RequisicionController@store', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'RequisicionController@show', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'RequisicionController@edit', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'RequisicionController@formatoPdf', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'RequisicionController@update', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'ArticulosController@create', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'ArticulosController@store', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'ArticulosController@edit', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'ArticulosController@update', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'ArticulosController@destroy', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);

        //-- Recibir Solicitudes --//
        Accion::create(['ruta' => 'RecibirController@seleccionarSol', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'RecibirController@recibirSol', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);

        //-- Solicitudes --//
        Accion::create(['ruta' => 'SolicitudController@index', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'SolicitudController@create', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'SolicitudController@store', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'SolicitudController@show', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'SolicitudController@edit', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'SolicitudController@formatoPdf', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'SolicitudController@update', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'SolicitudRecursosController@create', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'SolicitudRecursosController@store', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'SolicitudRecursosController@edit', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'SolicitudRecursosController@update', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'SolicitudRecursosController@destroy', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);

        //-- Invitaciones --//
        Accion::create(['ruta' => 'InvitacionController@index', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'InvitacionController@create', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'InvitacionController@store', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'InvitacionController@show', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'InvitacionController@invitacionPDF', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'InvitacionController@edit', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'InvitacionController@update', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'InvitacionController@destroy', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);

        //-- Martiz Cuadro Comparativo --//
        Accion::create(['ruta' => 'MatrizCuadroController@create', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'MatrizCuadroController@store', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'MatrizCuadroController@show', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'MatrizCuadroController@edit', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'MatrizCuadroController@update', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'CuadroController@cuadroPdf', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'CuadroController@update', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'CuadroController@destroy', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);

        //-- Ordenes de compra --//
        Accion::create(['ruta' => 'OcsController@index', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'OcsController@store', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'OcsController@ordenCompraPdf', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
    }
}