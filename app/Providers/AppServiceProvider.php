<?php

namespace Guia\Providers;

use View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('partials.menu.dynamic', 'Guia\Http\Composers\MenuComposer');
        View::composer('partials.filtroPresupuesto', 'Guia\Http\Composers\FiltroPresupuestoComposer');
        View::composer('partials.usuariosAsignados', 'Guia\Http\Composers\UsuariosAsignadosComposer');
    }

    /**
     * Register any application services.
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
