<?php namespace Guia\Providers;

use Illuminate\Support\ServiceProvider;

class ConsecutivoServiceProvider extends ServiceProvider {

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
		$this->app->bind('consecutivo', 'Guia\Classes\Consecutivo');
	}

}
