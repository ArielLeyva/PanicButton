<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Laravel\Sanctum\PersonalAccessToken;

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
            // $client->tokens()->delete();
            //Generar token API
            $token = $client->createToken($request->device_name)->plainTextToken;
            return response()->json($token);
        }
        return response('Unauthorized', 401);
    }

    public function getActiveSessions()
    {
        $client = $this->_getAuthClient();
        if ($client !== null) {
            if ($client !== false) {
                $tokens = [];
                foreach ($client->tokens as $token) {
                    $tokens[] = Arr::except($token->toArray(), ['token', 'tokenable_type', 'tokenable_id', 'abilities']);
                }
                return response()->json($tokens);
            } else {
                return response('No Content', 204);
            }
        } else {
            return response('Unauthorized', 401);
        }
    }

    public function destroy($id)
    {
        $session = PersonalAccessToken::find($id);
        if ($session->tokenable->id == $this->getIdByToken()) {
            $result = $session->delete();
            if ($result) {
                return response('');
            } else {
                return response('No se pudo eliminar el botón', 422);
            }
        } else {
            return response('Aunauthorized', 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        Session::flush();
        Auth::logout();
        return redirect('login');
    }
}
