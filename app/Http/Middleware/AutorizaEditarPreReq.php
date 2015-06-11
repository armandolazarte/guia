<?php namespace Guia\Http\Middleware;

use Closure;

class AutorizaEditarPreReq {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        $prereq_id = $request->route()->getParameter('prereq_id');
        $prereq = \Guia\Models\PreReq::whereId($prereq_id)->get(['user_id', 'estatus']);

        //Valida que el usuario sea el dueño de la req y que la req no esté enviada
        if(\Auth::user()->id != $prereq[0]->user_id || $prereq[0]->estatus != ''){
            return redirect()->action('PreReqController@show', array($prereq_id))->with(['alert-class' => 'alert-warning', 'message' => 'No puede editar esta solicitud']);
        }

        return $next($request);
	}

}
