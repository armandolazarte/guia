<?php

namespace Guia\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Guia\Http\Middleware\VerifyCsrfToken::class,
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
        'auth' => \Guia\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \Guia\Http\Middleware\RedirectIfAuthenticated::class,
		'role' => 'Guia\Http\Middleware\UserRoleInModule',
        'selPresu' => 'Guia\Http\Middleware\SelPresupuestoEnSession',
        'autorizaEditarReq' => 'Guia\Http\Middleware\AutorizaEditarReq',
        'autorizaEditarSol' => 'Guia\Http\Middleware\AutorizaEditarSol',
        'autorizaEditarPreReq' => 'Guia\Http\Middleware\AutorizaEditarPreReq',
	];

}
