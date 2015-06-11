<?php namespace Guia\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [
		'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
		'Illuminate\Cookie\Middleware\EncryptCookies',
		'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
		'Illuminate\Session\Middleware\StartSession',
		'Illuminate\View\Middleware\ShareErrorsFromSession',
		'Guia\Http\Middleware\VerifyCsrfToken',
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth' => 'Guia\Http\Middleware\Authenticate',
		'auth.basic' => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
		'guest' => 'Guia\Http\Middleware\RedirectIfAuthenticated',
		'role' => 'Guia\Http\Middleware\UserRoleInModule',
        'selPresu' => 'Guia\Http\Middleware\SelPresupuestoEnSession',
        'autorizaEditarReq' => 'Guia\Http\Middleware\AutorizaEditarReq',
        'autorizaEditarSol' => 'Guia\Http\Middleware\AutorizaEditarSol',
        'autorizaEditarPreReq' => 'Guia\Http\Middleware\AutorizaEditarPreReq',
	];

}
