<?php namespace Guia\Providers;

use View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		View::composer('partials.menu', 'Guia\Http\Composers\MenuComposer');
        View::composer('partials.filtroPresupuesto', 'Guia\Http\Composers\FiltroPresupuestoComposer');
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'Guia\Services\Registrar'
		);
	}

}
