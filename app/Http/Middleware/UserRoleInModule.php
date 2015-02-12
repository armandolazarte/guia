<?php namespace Guia\Http\Middleware;

use Guia\Models\Accion;
use Closure;

class UserRoleInModule {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$user = $request->user();

		//Determinar ruta para determinar acción
		$ruta_actual = $request->path();

		$accion = Accion::whereRuta($ruta_actual)->with('modulos')->get();

		//Consultar modulo(s) al que pertenece la acción
		$modulos_accion = $accion[0]->modulos;

		//Consultar roles que permiten el acceso al modulo
		foreach($modulos_accion as $modulo){
			foreach($modulo->roles as $role){
				$arr_roles_id_modulo[] = $role->id;
			}
		}

		//Consultar roles del usuario
		foreach($user->roles as $role){
			$arr_roles_id_usuario[] = $role->id;
		}

		//Validar roles del usuario contra roles del módulo
		$arr_validacion = array_intersect($arr_roles_id_usuario, $arr_roles_id_modulo);
		if ( count($arr_validacion) == 0) {
			/**
			 * @todo Redireccionar a página de inicio del usuario
			 */
			return redirect('/')->with('flash_message', 'No tiene los derechos para acceder a este módulo');
		}

		return $next($request);
	}

}
