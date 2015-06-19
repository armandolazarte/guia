<?php namespace Guia\Http\Controllers\Util;

use Guia\Http\Requests;
use Guia\Http\Controllers\Controller;

use Guia\User;
use Illuminate\Http\Request;

class ActivarCuentaController extends Controller {

	public function legacyLogin()
    {
        return view('util.activar_cuenta.formLegacyLogin');
    }

    public function legacyLoginCheck(Request $request)
    {
        $legacy_username = $request->input('legacy_username');
        $legacy_psw = md5($request->input('legacy_psw'));

        $legacy_user = \DB::connection('legacy')->table('tbl_usuarios')
            ->where('usr', '=', $legacy_username)
            ->get(['usr','psw']);

        if($legacy_user[0]->psw == $legacy_psw) {
            $user = User::whereLegacyUsername($legacy_username)->first();

            //Verifica si la cuenta ya está activa y en su caso redirecciona a login
            if($user->active == 1) {
                return redirect()->action('Auth\GuiaAuthController@getLogin')
                    ->with(['message' => 'Su cuenta ya está activa, por favor inicie sesión', 'alert-class' => 'alert-info']);
            }

            //Inicia sesión para el usuario
            \Auth::loginUsingId($user->id);

            return redirect()->action('Util\ActivarCuentaController@formUsuario');

        } else {
            return redirect()->action('Util\ActivarCuentaController@legacyLogin')
                ->with(['message' => 'El nombre de usuario o contraseña no coinciden', 'alert-class' => 'alert-danger']);
        }

    }

    public function formUsuario()
    {
        $user = User::find(\Auth::user()->id);
        return view('util.activar_cuenta.formActivarUsuario', compact('user'));
    }

    public function activarUsuario(Requests\ActivarCuentaRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $all_request = $request->all();
        $all_request['password'] = bcrypt($all_request['password']);
        $user->update($all_request);

        $user->roles()->attach(3);//$rol_id (3) => corresponde a rol "usuario"

        return redirect()->action('PaginasController@inicioUsuario')
            ->with(['message' => 'Su cuenta ha sido activada con éxito.', 'alert-class' => 'alert-success']);
    }

}
