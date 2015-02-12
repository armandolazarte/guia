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
});

Route::group(array('prefix' => 'admin'), function()
{
	Route::resource('usuario', 'UsuarioController');

	Route::get('/acciones', 'AccionesController@index');
	Route::get('/acciones/editar/{accion}', 'AccionesController@editar');
	Route::post('/acciones/actualizar/{accion}', 'AccionesController@actualizar');
});

Route::group(array('prefix' => 'pruebas'), function()
{
	Route::get('/menu', function()
	{
		return view('pruebas.menu');
	});
});
