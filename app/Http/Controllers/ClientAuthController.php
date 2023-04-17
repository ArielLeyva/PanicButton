<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;

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
            'email' => ['required'],
            'password' => ['required'],
            'device_name' => ['required']
        ]);
        if (Auth::guard('client')->attempt(['email' => $credentials['email'], 'password' => $credentials['password']], true)) {
            $client = Client::where('email', $credentials['email'])->first();
            //TODO (Eliminar esta función para mantener la cuenta en varios dispositivos)
            $client->tokens()->delete();
            //Generar token API
            $token = $client->createToken($request->device_name)->plainTextToken;
            return response()->json($token);
        }
        // $user = Client::where('email', $request->email)->first();
        // if (!$user || !Hash::check($request->password, $user->password)) {
        //     return response()->json([
        //         'message' => 'Authentication Error'
        //     ]);
        // }
        // return $user->createToken($request->device_name)->plainTextToken;
        return response()->json($user->createToken($request->device_name)->plainTextToken);

    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        Session::flush();
        Auth::logout();
        return redirect('login');
    }
}
