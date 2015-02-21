<?php namespace Guia\Providers;

use Illuminate\Support\ServiceProvider;

class InfoDirectivosServiceProvider extends ServiceProvider {

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
        $this->app->bind('info_directivos', 'Guia\Classes\InfoDirectivos');
	}

}
