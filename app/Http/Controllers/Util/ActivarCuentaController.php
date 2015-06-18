<?php namespace Guia\Http\Controllers\Util;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

use Guia\User;
use Illuminate\Http\Request;

class ActivarCuentaController extends Controller {

	public function legacyLogin()
    {
        /**
         * @todo Crear fomulario en formLegacyLogin
         */

        return view('util.activar_cuenta.formLegacyLogin');
    }

    public function legacyLoginCheck(Request $request)
    {
        $legacy_username = $request->input('legacy_username');
        $legacy_psw = $request->input('legacy_psw');

        $legacy_user = \DB::connection('legacy')->table('tbl_usuarios')
            ->where('usr', '=', $legacy_username)
            ->get(['usr','psw']);

        if($legacy_user->psw == $legacy_psw) {
            /**
             * @todo Consultar id de usuario
             * @todo Condición en caso de que la cuenta ya esté activa: Redireccionar a /login c/mensaje
             * @todo Crear sesión
             */

            return redirect()->action('ActivarCuentaController@formUser', []);
        } else {
            return redirect()->action('ActivarCuentaController@legacyLogin');
        }

    }

    public function formUser()
    {
        /**
         * @todo Agregar condiciones para no mostrar seleccción de roles, cargos y urgs en formUsuario
         */
        $user = User::find(\Auth::user()->id);

        return view('admin.usuarios.formUsuario', compact('user'));
    }

    public function updateUser(UsuarioFormRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $all_request = $request->all();
        $all_request['password'] = bcrypt($all_request['password']);
        $user->update($all_request);

        /**
         * @todo Agregar rol usuario-urg por default
         * @todo Agregar mensaje a mostrar en landing page
         */

        return redirect()->action('PaginasController@inicioUsuario');
    }

}
