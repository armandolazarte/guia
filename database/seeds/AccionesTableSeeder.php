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

        //-- Autorizar Requisición --//
        Accion::create(['ruta' => 'AutorizarReqController@formAutorizar', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'AutorizarReqController@asignarRms', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'AutorizarReqController@desautorizar', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);

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
        Accion::create(['ruta' => 'OcsCondicionesController@edit', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'OcsCondicionesController@update', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);

        //-- Reportes Presupuesto --//
        Accion::create(['ruta' => 'PresupuestoController@saldoRms', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'PresupuestoController@reporteEgresosProyecto', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);

        //-- Compensaciones --//
        Accion::create(['ruta' => 'ompensaInternaController@index', 'nombre' => 'Listado', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'ompensaInternaController@create', 'nombre' => 'Nueva Compensación', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'ompensaInternaController@store', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);

        //-- Pre-Requisición (Solicitud) --//
        Accion::create(['ruta' => 'PreReqController@index', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'PreReqController@create', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'PreReqController@store', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'PreReqController@show', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'PreReqController@edit', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'PreReqController@update', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'PreReqArticulosController@create', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'PreReqArticulosController@store', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'PreReqArticulosController@edit', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'PreReqArticulosController@update', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'PreReqArticulosController@destroy', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);

        //-- Almacén --//
        Accion::create(['ruta' => 'EntradaOcController@index', 'nombre' => 'Nueva Entrada (OC)', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'EntradaOcController@create', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'EntradaOcController@store', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'EntradaOcController@formatoPdf', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'SalidaController@create', 'nombre' => 'Nueva Salida', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'SalidaController@store', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'SalidaController@show', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'SalidaController@formatoPdf', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);

        //-- Sol. Depósito Concentradora --//
        Accion::create(['ruta' => 'SolDepositoController@create', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'SolDepositoController@store', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'SolDepositoDocsController@create', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'SolDepositoDocsController@store', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);

        //-- Egresos --//
        Accion::create(['ruta' => 'EgresosController@index', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'EgresosController@create', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'EgresosController@store', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'EgresosController@show', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'EgresosController@edit', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'EgresosController@update', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'EgresosController@chequeRtf', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);

        Accion::create(['ruta' => 'GenerarEgresoController@create', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'GenerarEgresoController@store', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);

        //-- Relaciones Internas --//
        Accion::create(['ruta' => 'RelacionInternaController@index', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'RelacionInternaController@store', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'RelacionInternaController@show', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'RelacionInternaController@edit', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'RelacionInternaController@update', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'RelacionInternaDocController@create', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'RelacionInternaDocController@store', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'RelacionInternaDocController@edit', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'RelacionInternaDocController@update', 'nombre' => '', 'icono' => '', 'orden' => '', 'activo' => '0']);

        //-- Administración de Usuarios --//
        Accion::create(['ruta' => 'UsuarioController@index', 'nombre' => 'Usuarios', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'CargosController@store', 'nombre' => 'Asignar Cargo', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'AccesosController@store', 'nombre' => 'Acceso Presupuestal', 'icono' => '', 'orden' => '', 'activo' => '0']);
        Accion::create(['ruta' => 'AsignarUsuariosController@store', 'nombre' => 'Asignar Usuarios', 'icono' => '', 'orden' => '', 'activo' => '0']);
    }
}