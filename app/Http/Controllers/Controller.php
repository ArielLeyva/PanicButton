<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function getIdByToken() {
        $token = PersonalAccessToken::findToken(request()->bearerToken());
        if($token) {
            $user = $token->tokenable;
            if($user) {
                return $user->id;
            }
        }
        return null;
    }

    protected function isClientRequest(Request $request) {
        return Str::startsWith($request->path(), 'api/client');
    }
}
