<?php namespace Guia\Http\Middleware;

use Closure;

class SelPresupuestoEnSession {

	/**
	 * Actualiza o crea la variable de sesión sel_presupuesto.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        $sel_presupuesto = $request->sel_presupuesto;
        if(isset($sel_presupuesto)){
            \Session::put('sel_presupuesto', $request->sel_presupuesto);
        } else {
            if(!(\Session::has('sel_presupuesto'))){
                \Session::put('sel_presupuesto', \Carbon\Carbon::now()->year);
            }
        }

		return $next($request);
	}

}
