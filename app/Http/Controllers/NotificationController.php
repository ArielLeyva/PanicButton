<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::all();
        $sort = $notifications->sortByDesc('created_at');
        return response()->json($sort->values()->all());
    }

    public function getClientNotifications(Request $request)
    {
        $token = PersonalAccessToken::findToken(request()->bearerToken());
        if ($token) {
            $user = $token->tokenable;
            if ($user) {
                $items = Notification::where('client_id', $user->id)->get();
                $notifications = [];
                foreach ($items as $notification) {
                    $notifications[] = [
                        'id' => $notification['id'],
                        'title' => $notification['title'],
                        'content' => $notification['content'],
                        'created_at' => $notification['created_at'],
                        'updated_at' => $notification['updated_at'],
                    ];
                }
                return response()->json($notifications);
            } else {
                return response('No Content', 204);
            }
        } else {
            return response('Unauthorized', 401);
        }
    }

    /**
     * Eliminar registros de la base de datos a partir del id pasado en la petición
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = Notification::destroy($id);
        if ($result) {
            return response('');
        } else {
            return response('No se pudo eliminar la notificación', 422);
        }
    }
}
