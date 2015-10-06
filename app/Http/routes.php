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

Route::post('/archivos/cargar', 'ArchivosController@store');
Route::get('/archivos/descargar/{id}', 'ArchivosController@descargar');
Route::delete('/archivos/eliminar/{id?}', 'ArchivosController@destroy');

Route::post('/buscar-documento', 'SearchController@buscarDocumento');

Route::group(array('prefix' => 'admin/su', 'middleware' => ['auth']), function()
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

    Route::get('importar-registros', 'ImportarRegistrosController@index');
    Route::post('importar-registros', 'ImportarRegistrosController@importar');

    Route::get('importar-ejercicio', 'ImportarEjercicioController@index');
    Route::post('importar-ejercicio', 'ImportarEjercicioController@importar');
});

Route::group(array('prefix' => 'admin', 'middleware' => ['auth']), function()
{
	Route::resource('usuario', 'UsuarioController');
    Route::get('usuario/asignado/login/{id}', 'UsuarioAsignadoController@loginAsignado');
    Route::post('usuario/cargos/store/{$user_id}', 'CargosController@store');
    Route::post('usuario/acceso/store', 'AccesosController@store');
    Route::post('usuario/asignar-usuario/store', 'AsignarUsuariosController@store');

	Route::get('/tiposProyectos/', 'TiposProyectosController@index');
	Route::get('/tiposProyectos/nuevo', 'TiposProyectosController@create');
	Route::get('/tiposProyectos/editar/{tipoProyecto}', 'TiposProyectosController@edit');
	Route::post('/tiposProyectos/{tipoProyecto}', 'TiposProyectosController@store');
	Route::post('/tiposProyectos/actualizar/{tipoProyecto}', 'TiposProyectosController@update');

    Route::post('/beneficiarios', 'BenefController@store');
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

	Route::match(['get', 'post'], '/reporte/{scope?}/{estatus?}', 'RequisicionController@index');
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

    Route::get('/reporte/{scope?}/{estatus?}', 'SolicitudController@index');
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
    Route::get('/{id}', 'OcsController@show');
    Route::get('/{id}/pdf', 'OcsController@ordenCompraPdf');
    Route::get('/condiciones/{id}', 'OcsCondicionesController@edit');
    Route::patch('/condiciones/{id}', 'OcsCondicionesController@update');
    Route::delete('/{id}', 'OcsController@destroy');
});

//** Presupuesto **//
Route::group(array('prefix' => 'presupuesto', 'middleware' => ['auth']), function()
{
    Route::get('/ejercicio-proyecto', 'EjercicioController@ejercicioProyectoRms');
    Route::get('/get-ejercicio-proyecto', 'EjercicioController@getEjercicioProyectoRms');
    Route::get('/egresos-proyecto/{proyecto_id?}', 'PresupuestoController@reporteEgresosProyecto');
});

//** Recursos Materiales */
Route::group(array('prefix' => 'rm', 'middleware' => ['auth']), function()
{
    Route::get('/compensacion-interna/', 'CompensaInternaController@index');
    Route::get('/compensacion-interna/nueva', 'CompensaInternaController@create');
    Route::post('/compensacion-interna/nueva', 'CompensaInternaController@store');
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

//** Entradas de Almacén **//
Route::group(array('prefix' => 'almacen/entrada', 'middleware' => ['auth']), function()
{
    Route::get('/oc', 'EntradaOcController@index');
    Route::get('/oc/{oc}', 'EntradaOcController@create');
    Route::post('/oc', 'EntradaOcController@store');
    Route::get('/formato/{id}', 'EntradaOcController@formatoPdf');
});

//** Salidas de Almacén **//
Route::group(array('prefix' => 'almacen/salida', 'middleware' => ['auth']), function()
{
    Route::get('/{entrada_id}/nueva', 'SalidaController@create');
    Route::post('/', 'SalidaController@store');
    Route::get('/{id}', 'SalidaController@show');
    Route::get('/formato/{id}', 'SalidaController@formatoPdf');
});

//** Solicitud Depósito Concentradora  **//
Route::group(array('prefix' => 'sol-dep-concentradora', 'middleware' => ['auth']), function()
{
    Route::get('/nueva', 'SolDepositoController@create');
    Route::post('/nueva', 'SolDepositoController@store');
    Route::get('/{soldep_id}/agregar-doc', 'SolDepositoDocsController@create');
    Route::post('/agregar-doc', 'SolDepositoDocsController@store');
});

//** Egresos */
Route::group(array('prefix' => 'egresos', 'middleware' => ['auth']), function()
{
    Route::get('/generar', 'GenerarEgresoController@create');
    Route::post('/generar', 'GenerarEgresoController@store');

    Route::get('/reporte/{scope?}/{estatus?}', 'EgresosController@index');
    Route::get('/listado', 'EgresosController@index');
    Route::get('/nuevo', 'EgresosController@create');
    Route::post('/nuevo', 'EgresosController@store');
    Route::get('/{id}/info', 'EgresosController@show');
    Route::get('/{id}/editar', 'EgresosController@edit');
    Route::patch('/{id}/editar', 'EgresosController@update');
    Route::delete('/{id}/cancelar', 'EgresosController@cancelar');
    Route::get('/{id}/imprimir', 'EgresosController@chequeRtf');
});

//** Relaciones Internas */
Route::group(array('prefix' => 'relaciones-internas', 'middleware' => ['auth']), function()
{
    Route::get('/', 'RelacionInternaController@index');
    Route::post('/nueva', 'RelacionInternaController@store');
    Route::get('/{rel_interna_id}/agregar-docs', 'RelacionInternaDocController@create');
    Route::post('/agregar-docs', 'RelacionInternaDocController@store');

    Route::get('/{rel_interna_id}/recibir-docs', 'RelacionInternaDocController@edit');
    Route::patch('/{rel_interna_id}/recibir-docs', 'RelacionInternaDocController@update');

    Route::get('/{rel_interna_id}/info', 'RelacionInternaController@show');
    Route::get('/{rel_interna_id}/editar', 'RelacionInternaController@edit');
    Route::patch('/{rel_interna_id}/update', 'RelacionInternaController@update');
    Route::delete('/{rel_interna_id}/borrar-doc/{id}', 'RelacionInternaDocController@destroy');
});

/** Bancos */
Route::group(array('prefix' => 'bancos', 'middleware' => ['auth']), function() {
    Route::get('/egresos-benef', 'BancoController@reporteEgresosBenef');

    /** Conciliación Bancaria */
    Route::get('/conciliacion/auxiliar-libros/{cuenta_bancaria_id}/{aaaa}/{mes}', 'ConciliacionBancariaController@auxiliarLibros');
    Route::get('/conciliacion/no-identificados/{cuenta_bancaria_id}/{aaaa}/{mes}', 'ConciliacionBancariaController@noIdentificados');
});

/** No Identificados */
Route::group(array('prefix' => 'bancos/no-identificados', 'middleware' => ['auth']), function() {
    Route::match(['get','post'], '/', 'NoIdentificadoController@index');
    Route::get('/{id}/info', 'NoIdentificadoController@show');
    Route::get('/nuevo', 'NoIdentificadoController@create');
    Route::post('/nuevo', 'NoIdentificadoController@store');
    Route::get('/{id}/editar', 'NoIdentificadoController@edit');
    Route::patch('/{id}/editar', 'NoIdentificadoController@update');
    Route::delete('/{id}/borrar', 'NoIdentificadoController@destroy');
});

Route::group(array('prefix' => 'api', 'middleware' => ['auth']), function()
{
    Route::get('/rm-dropdown/', function()
    {
        $proyecto_id = \Input::get('proyecto_id');
        $rms = \Guia\Models\Rm::where('proyecto_id', '=', $proyecto_id)->get(['rm','id']);
        return response()->json($rms);
    });

    Route::get('/proyectos-dropdown/', function()
    {
        $arr_proyectos = \FiltroAcceso::getArrProyectos();
        foreach ($arr_proyectos as $k => $v) {
            $proyectos[] = ['id' => $k, 'proyecto_descripcion' => $v];
        }
        return response()->json($proyectos);
    });

    Route::get('/egresos-proyecto/', function()
    {
        $proyecto_id = \Input::get('proyecto_id');
        $egresos = \Guia\Models\Proyecto::findOrFail($proyecto_id)
            ->egresos()
            ->with('benef','cuentaBancaria','cuenta','user')
            ->with('rms.cog')
            ->get();

        return response()->json($egresos);
    });

    Route::get('/egresos-benef/', function()
    {
        $benef_id = \Input::get('benef_id');
        $egresos = \Guia\Models\Benef::findOrFail($benef_id)
            ->egresos()
            ->with('benef')
            ->with('cuentaBancaria')
            ->with('cuenta')
            ->with('user')
            ->get();

        return response()->json($egresos);
    });

    Route::get('/benef-search/', function()
    {
        $benef_search = \Input::get('term');
        $benefs = \Guia\Models\Benef::where('benef', 'LIKE', '%'.$benef_search.'%')
            ->orderBy('benef')
            ->get(['benef']);
        foreach ($benefs as $benef) {
            $arr_benefs[] = ['value' => $benef->benef];
        }

        return response()->json($arr_benefs);
    });

    Route::get('/benef-id/', function()
    {
        $benef = \Input::get('benef');
        $benef_id = \Guia\Models\Benef::where('benef', 'LIKE', $benef)->pluck('id');
        $arr_benef_id = ['benef_id' => $benef_id];
        return response()->json($arr_benef_id);
    });
});

