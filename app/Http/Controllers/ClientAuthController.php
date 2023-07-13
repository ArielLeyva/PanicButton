<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Client;
use Exception;
use Illuminate\Support\Arr;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Socialite\Facades\Socialite;
use Kreait\Firebase\Factory;

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
        $factory = (new Factory)->withServiceAccount(base_path() . '/' . env('FIREBASE_CREDENTIALS', '/config/firebase_auth_file.json'));
        $auth = $factory->createAuth();
        try {
            $verifiedIdToken = $auth->verifyIdToken($request->token);
            $uid = $verifiedIdToken->claims()->get('sub');
            $user = $auth->getUser($uid);
            $client = Client::where('email', $user->email)->first();
            if ($client) {
                $token = $client->createToken($request->device_name)->plainTextToken;
                return response()->json($token);
            } else {
                return response('No hay ningun usuario asociado a su dirección de correo electónico', 201);
            }
        } catch (Exception $e) {
            return response('Unauthorized', 401);
        }
    }

    public function googleAutenticate(Request $request)
    {
        // Getting the user from socialite using token from google
        $user = Socialite::driver('google')->stateless()->userFromToken($request->token);

        $client = Client::where('email', $user->getEmail())->first();
        if ($client) {
            $token = $client->createToken($request->device_name)->plainTextToken;
            return response()->json($token);
        } else {
            return response('No hay ningun usuario asociado a su dirección de correo electónico de Google', 201);
        }
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

    public function logout()
    {
        $token = PersonalAccessToken::findToken(request()->bearerToken());
        $token->delete();
        Session::flush();
        Auth::logout();
        return response('');
    }
}
