<?php

namespace Guia\Http\Middleware;

use Closure;
use Guia\Classes\ControlOperacionHelper;
use Guia\Models\OpRestringida;

class ControlOperacion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $modelo)
    {
        //Permite la operación si no se está enviando la Req||Sol
        $accion = $request->input('accion');
        if (!empty($accion)) {
            if ($accion != 'Enviar') {
                return $next($request);
            }
        }

        $proyecto_id = $request->input('proyecto_id');
        $documento_id = null;
        if (empty($proyecto_id)) {
            if ($modelo == 'Req') {
                $documento_id = $request->route()->getParameter('req_id');
            }
            if ($modelo == 'Solicitud') {
                $documento_id = $request->route()->getParameter('solicitud');
            }
            if (empty($documento_id)) {
                return redirect()->back()->with(['message' => 'Error al validar operación']);
            }
        }

        $operacion = new ControlOperacionHelper($modelo, $proyecto_id, $documento_id);
        $valida = $operacion->validarOperacion();

        if (!$valida) {
            return redirect()->back()->with([
                'alert-class' => 'alert-danger',
                'message' => 'Operación no permitida ('.$operacion->op_restringida->motivo.') '.$operacion->op_restringida->mensaje]);
        }

        return $next($request);
    }
}
