<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ClientAuthController extends Controller
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
            'username' => ['required'],
            'password' => ['required']
        ]);
        if (Auth::attempt($credentials, true)) {
            $request->user()->tokens()->delete();
            //Generar token API
            $token = $request->user()->createToken("pxsfs5qsslhp5sdpl548");
            return response()->json($token);
        }
        return response()->json([
            'message' => 'Authentication Error'
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        Session::flush();
        Auth::logout();
        return redirect('login');
    }
}
