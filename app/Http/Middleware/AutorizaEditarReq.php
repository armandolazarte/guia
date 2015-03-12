<?php namespace Guia\Http\Middleware;

use Closure;

class AutorizaEditarReq {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        $req_id = $request->route()->getParameter('req_id');
        $req = \Guia\Models\Req::whereId($req_id)->get(['solicita', 'estatus']);

        //Valida que el usuario sea el dueño de la req y que la req no esté enviada
        if(\Auth::user()->id != $req[0]->solicita || $req[0]->estatus != ''){
            return redirect()->action('RequisicionController@show', array($req_id))->with(['alert-class' => 'alert-warning', 'message' => 'No puede editar esta requisición']);
        }

		return $next($request);
	}

}
