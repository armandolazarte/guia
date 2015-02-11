<?php namespace Guia\Providers;

use Illuminate\Support\ServiceProvider;

class FiltroAccesoServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('filtro_acceso', 'Gia\Classes\FiltroAcceso');
	}

}
