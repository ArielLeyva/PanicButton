<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);

        $remember = $request->has('remember') && $request->boolean('remember');
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $request->user()->tokens()->delete();
            //Generar token API
            $token = $request->user()->createToken(csrf_token());
            //Guardar una cookie con el valor del token
            setcookie('TOKEN-API', $token->plainTextToken, time() + 3600 * 24);
            //Redirigir a la página de solicitud
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'username' => 'El nombre de usuario o contraseña es incorrecto',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        // // $request->session()->();
        // $request->user()->tokens()->delete();
        // return redirect()->intended('login');
        $request->user()->tokens()->delete();
        Session::flush();
        Auth::logout();
        return redirect('login');
    }
}
