<?php namespace Guia\Http\Controllers\Auth;

use Auth;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class GuiaAuthController extends Controller {

    /**
     * Show the application login form.
     *
     */
    public function getLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     */
    public function authenticate(Request $request)
    {

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials))
        {
            return redirect()->intended('/');
        }

        return redirect('/login')
            ->withInput($request->only('username'))
            ->withErrors([
                'username' => 'El código no se encuentra registrado.',
            ]);
    }

}
