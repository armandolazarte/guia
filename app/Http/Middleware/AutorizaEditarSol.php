<?php namespace Guia\Http\Middleware;

use Closure;

class AutorizaEditarSol {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        $sol_id = $request->route()->getParameter('solicitud');
        $sol = \Guia\Models\Solicitud::whereId($sol_id)->get(['solicita', 'estatus']);

        $user = \Auth::user();
        $arr_roles = $user->roles()->lists('role_name')->all();
        //Valida que el usuario sea el dueño de la req y que la req no esté enviada

        if(array_search('Presupuesto', $arr_roles) !== false || array_search('Comprobacion', $arr_roles) !== false) {
            return $next($request);
        }

        //dd(array_search('Presupuedsto', $arr_roles));
        if(\Auth::user()->id != $sol[0]->solicita || $sol[0]->estatus != ''){
            return redirect()->action('SolicitudController@show', array($sol_id))->with(['alert-class' => 'alert-warning', 'message' => 'No puede modificar esta solicitud']);
        }

		return $next($request);
	}

}
