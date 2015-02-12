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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
Route::get('/login', 'Auth\GuiaAuthController@getLogin');
Route::post('/login', 'Auth\GuiaAuthController@authenticate');

Route::group(array('prefix' => 'admin/su'), function()
{
	Route::get('/modulos', 'ModuloController@index');
	Route::get('/modulos/crear', 'ModuloController@create');
	Route::post('/modulos', 'ModuloController@store');
	Route::get('/modulos/{modulo}/editar', 'ModuloController@edit');
	Route::post('/modulos/{modulo}', 'ModuloController@update');

	//Importación de catálogos
	Route::get('/importar-catalogos', 'ImportaCatalogosController@index');
	Route::post('/importar', 'ImportaCatalogosController@importar');
});

Route::group(array('prefix' => 'admin'), function()
{
	Route::resource('usuario', 'UsuarioController');

	Route::get('/acciones', 'AccionesController@index');
	Route::get('/acciones/editar/{accion}', 'AccionesController@editar');
	Route::post('/acciones/actualizar/{accion}', 'AccionesController@actualizar');

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
Route::group(array('prefix' => 'req', 'middleware' => 'auth'), function()
{
	Route::get('/', 'RequisicionController@index');
	Route::get('/nueva', 'RequisicionController@create');
	Route::post('/store', 'RequisicionController@store');
	Route::get('/info/{req_id}', 'RequisicionController@show');

	Route::get('/articulos/agregar/{req_id}', 'ArticulosController@create');
	Route::post('/articulos/store', 'ArticulosController@store');
	Route::get('/articulos/{articulo}/editar', 'ArticulosController@edit');
	Route::patch('/articulos/{articulo}', 'ArticulosController@update');
	Route::delete('/articulos/{articulo}', 'ArticulosController@destroy');
});
