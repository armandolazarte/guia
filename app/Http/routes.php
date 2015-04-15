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

Route::get('home', 'HomeController@index');

//Route::controllers([
//	'auth' => 'Auth\AuthController',
//	'password' => 'Auth\PasswordController',
//]);
Route::get('/login', 'Auth\GuiaAuthController@getLogin');
Route::post('/login', 'Auth\GuiaAuthController@authenticate');

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

Route::group(array('prefix' => 'admin'), function()
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

Route::group(array('prefix' => 'pruebas'), function()
{
	Route::get('/menu', function()
	{
		return view('pruebas.menu');
	});
});

//** Requisiciones **//
Route::group(array('prefix' => 'req', 'middleware' => ['auth','selPresu']), function()
{
	Route::match(['get', 'post'], '/', 'RequisicionController@index');
	Route::match(['get', 'post'], '/nueva', 'RequisicionController@create');
	Route::post('/store', 'RequisicionController@store');
	Route::get('/{req_id}/info', 'RequisicionController@show');
    Route::get('/{req_id}/editar', ['middleware' => 'autorizaEditarReq', 'uses' => 'RequisicionController@edit']);
    Route::get('/{req_id}/pdf', 'RequisicionController@formatoPdf');
    Route::patch('/{req_id}', 'RequisicionController@update');

	Route::get('/{req_id}/articulos/agregar', ['middleware' => 'autorizaEditarReq', 'uses' => 'ArticulosController@create']);
	Route::post('/articulos/store', 'ArticulosController@store');
	Route::get('/{req_id}/articulos/{articulo}/editar', ['middleware' => 'autorizaEditarReq', 'uses' => 'ArticulosController@edit']);
	Route::patch('/articulos/{articulo}', 'ArticulosController@update');
	Route::delete('/articulos/{articulo}', 'ArticulosController@destroy');
});

//** Solicitudes **//
Route::group(array('prefix' => 'solicitud', 'middleware' => ['auth','selPresu']), function()
{
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
