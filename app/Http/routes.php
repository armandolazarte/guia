<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', 'WelcomeController@index');
Route::get('/', 'PaginasController@inicio');
Route::get('/formatos', 'PaginasController@formatos');
Route::get('/acercade', 'PaginasController@acercade');
Route::get('/manuales', 'PaginasController@manuales');
Route::get('/normatividad', 'PaginasController@normatividad');

Route::group(array('prefix' => 'activar-cuenta'), function() {
    Route::get('/', 'Util\ActivarCuentaController@legacyLogin');
    Route::post('/login', 'Util\ActivarCuentaController@legacyLoginCheck');
    Route::get('/usuario', ['uses' => 'Util\ActivarCuentaController@formUsuario', 'middleware' => 'auth']);
    Route::patch('/{id}/usuario', ['uses' => 'Util\ActivarCuentaController@activarUsuario', 'middleware' => 'auth']);
});

Route::group(array('prefix' => 'inicio', 'middleware' => 'auth'), function()
{
    Route::get('/usuario-urg', 'PaginasController@inicioUsuario');
    Route::get('/suministros', 'PaginasController@inicioSuministros');
    Route::get('/presupuesto', 'PaginasController@inicioPresupuesto');
    Route::get('/almacen', 'PaginasController@inicioAlmacen');
});

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
Route::get('/login', 'Auth\GuiaAuthController@getLogin');
Route::post('/login', 'Auth\GuiaAuthController@authenticate');

Route::post('/archivos/upload', 'ArchivosController@store');

Route::group(array('prefix' => 'admin/su'), function()
{
	Route::get('/modulos', 'ModuloController@index');
	Route::get('/modulos/crear', 'ModuloController@create');
	Route::post('/modulos', 'ModuloController@store');
	Route::get('/modulos/{modulo}/editar', 'ModuloController@edit');
	Route::post('/modulos/{modulo}', 'ModuloController@update');

    Route::get('/acciones', 'AccionesController@index');
    Route::get('/acciones/rutas', 'AccionesController@create');
    Route::post('/acciones/rutas', 'AccionesController@store');
    Route::get('/acciones/{accion}/editar', 'AccionesController@edit');
    Route::patch('/acciones/{accion}', 'AccionesController@update');

	//Importación de catálogos
	Route::get('/importar-catalogos', 'ImportaCatalogosController@index');
	Route::post('/importar-catalogos', 'ImportaCatalogosController@importar');
});

Route::group(array('prefix' => 'admin', 'middleware' => ['auth']), function()
{
	Route::resource('usuario', 'UsuarioController');
    Route::post('usuario/cargos/store/{$user_id}', 'CargosController@store');
    Route::post('usuario/acceso/store', 'AccesosController@store');

	Route::get('/tiposProyectos/', 'TiposProyectosController@index');
	Route::get('/tiposProyectos/nuevo', 'TiposProyectosController@create');
	Route::get('/tiposProyectos/editar/{tipoProyecto}', 'TiposProyectosController@edit');
	Route::post('/tiposProyectos/{tipoProyecto}', 'TiposProyectosController@store');
	Route::post('/tiposProyectos/actualizar/{tipoProyecto}', 'TiposProyectosController@update');
});

Route::group(array('prefix' => 'proyectos'), function() {
	Route::get('/', 'ProyectosController@index');
	Route::get('/importar', 'ImportarProyectoController@index');
	Route::post('/upload', 'ImportarProyectoController@postUpload');
	Route::post('/convertir', 'ImportarProyectoController@convertir');
	Route::get('/vista-previa', 'ImportarProyectoController@show');
	Route::post('/importar/', 'ImportarProyectoController@store');
});

Route::group(array('prefix' => 'pruebas', 'middleware' => ['auth']), function()
{
	Route::get('/menu', function()
	{
		return view('pruebas.menu');
	});
});

//** Requisiciones **//
Route::group(array('prefix' => 'req', 'middleware' => ['auth','selPresu']), function()
{
    Route::get('/recibir', 'RecibirController@seleccionarReq');
    Route::patch('/recibir', 'RecibirController@recibirReq');

	Route::match(['get', 'post'], '/filtro/{scope?}', 'RequisicionController@index');
	Route::match(['get', 'post'], '/nueva', 'RequisicionController@create');
	Route::post('/store', 'RequisicionController@store');
	Route::get('/{req_id}/info', 'RequisicionController@show');
    Route::get('/{req_id}/editar', ['middleware' => 'autorizaEditarReq', 'uses' => 'RequisicionController@edit']);
    Route::get('/{req_id}/pdf', 'RequisicionController@formatoPdf');
    Route::patch('/{req_id}/actualizar', 'RequisicionController@update');

	Route::get('/{req_id}/articulos/agregar', ['middleware' => 'autorizaEditarReq', 'uses' => 'ArticulosController@create']);
	Route::post('/articulos/store', 'ArticulosController@store');
	Route::get('/{req_id}/articulos/{articulo}/editar', ['middleware' => 'autorizaEditarReq', 'uses' => 'ArticulosController@edit']);
	Route::patch('/articulos/{articulo}', 'ArticulosController@update');
	Route::delete('/articulos/{articulo}', 'ArticulosController@destroy');

    Route::get('/{id}/autorizar', 'AutorizarReqController@formAutorizar');
    Route::patch('/asignar-rms', 'AutorizarReqController@asignarRms');
    Route::patch('/{id}/desautorizar', 'AutorizarReqController@desautorizar');
});

//** Solicitudes **//
Route::group(array('prefix' => 'solicitud', 'middleware' => ['auth','selPresu']), function()
{
    Route::get('/recibir', 'RecibirController@seleccionarSol');
    Route::patch('/recibir', 'RecibirController@recibirSol');

    Route::get('/', 'SolicitudController@index');
    Route::get('/nueva', 'SolicitudController@create');
    Route::post('/store', 'SolicitudController@store');
    Route::get('/{solicitud}/info', 'SolicitudController@show');
    Route::get('/{solicitud}/editar', ['middleware' => 'autorizaEditarSol', 'uses' => 'SolicitudController@edit']);
    Route::get('/{solicitud}/pdf', 'SolicitudController@formatoPdf');
    Route::patch('/{solicitud}', 'SolicitudController@update');

    Route::get('/{solicitud}/recurso/agregar', ['middleware' => 'autorizaEditarSol', 'uses' => 'SolicitudRecursosController@create']);
    Route::post('/recurso/store', 'SolicitudRecursosController@store');
    Route::get('/{solicitud}/recurso/{recurso}/editar', ['middleware' => 'autorizaEditarSol', 'uses' => 'SolicitudRecursosController@edit']);
    Route::patch('/{solicitud}/recurso/{recurso}', 'SolicitudRecursosController@update');
    Route::delete('/{solicitud}/recurso/{recurso}', 'SolicitudRecursosController@destroy');
});

//** Invitaciones  **//
Route::group(array('prefix' => 'invitacion', 'middleware' => ['auth']), function()
{
    Route::get('/{req_id}', 'InvitacionController@index');
    Route::get('/{req_id}/nueva', 'InvitacionController@create');
    Route::post('/{req_id}/nueva', 'InvitacionController@store');
    Route::get('/{id}/info', 'InvitacionController@show');
    Route::get('/{id}/pdf', 'InvitacionController@invitacionPDF');
    Route::get('/{id}/editar', 'InvitacionController@edit');
    Route::patch('/{id}', 'InvitacionController@update');
    Route::delete('/{id}', 'InvitacionController@destroy');
});

//** MatrizCuadro **//
Route::group(array('prefix' => 'cuadro-comparativo', 'middleware' => ['auth']), function()
{
    Route::get('/{req_id}/nuevo', 'MatrizCuadroController@create');
    Route::post('/', 'MatrizCuadroController@store');
    Route::get('/{req_id}', 'MatrizCuadroController@show');
    Route::get('/{id}/editar', 'MatrizCuadroController@edit');
    Route::patch('/{id}/update', 'MatrizCuadroController@update');
    Route::get('/{id}/pdf', 'CuadroController@cuadroPdf');
    Route::patch('/{id}', 'CuadroController@update');
    Route::delete('/{id}', 'CuadroController@destroy');
});

//** OCs **//
Route::group(array('prefix' => 'oc', 'middleware' => ['auth']), function()
{
    Route::get('/req/{req_id}', 'OcsController@index');
    Route::post('/req/{req_id}', 'OcsController@store');
    Route::get('/{id}/pdf', 'OcsController@ordenCompraPdf');
    Route::get('/condiciones/{id}', 'OcsCondicionesController@edit');
    Route::patch('/condiciones/{id}', 'OcsCondicionesController@update');
});

//** Presupuesto **//
Route::group(array('prefix' => 'presupuesto', 'middleware' => ['auth']), function()
{
    Route::get('/saldo-proyecto/{id}/{modo_tabla?}', 'PresupuestoController@saldoRms');
});

//** Pre Requisiciones **//
Route::group(array('prefix' => 'solicitud-req', 'middleware' => ['auth','selPresu']), function()
{
    Route::match(['get', 'post'], '/', 'PreReqController@index');
    Route::match(['get', 'post'], '/nueva', 'PreReqController@create');
    Route::post('/store', 'PreReqController@store');
    Route::get('/{prereq_id}/info', 'PreReqController@show');
    Route::get('/{prereq_id}/editar', ['middleware' => 'autorizaEditarPreReq', 'uses' => 'PreReqController@edit']);
    Route::patch('/{prereq_id}', 'PreReqController@update');

    Route::get('/{prereq_id}/articulos/agregar', ['middleware' => 'autorizaEditarPreReq', 'uses' => 'PreReqArticulosController@create']);
    Route::post('/articulos/store', 'PreReqArticulosController@store');
    Route::get('/{prereq_id}/articulos/{articulo}/editar', ['middleware' => 'autorizaEditarPreReq', 'uses' => 'PreReqArticulosController@edit']);
    Route::patch('/articulos/{articulo}', 'PreReqArticulosController@update');
    Route::delete('/articulos/{articulo}', 'PreReqArticulosController@destroy');
});
