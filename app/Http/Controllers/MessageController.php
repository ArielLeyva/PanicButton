<?php

namespace App\Http\Controllers;

use App\Events\MessageRemoved;
use App\Events\MessageSended;
use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::all()->groupBy('client_id');
        $sort = $messages->sortByDesc('created_at');
        return response()->json($sort->values()->all());
    }

    public function getClientMessages(Request $request)
    {
        $token = PersonalAccessToken::findToken(request()->bearerToken());
        if ($token) {
            $user = $token->tokenable;
            if ($user) {
                $items = Message::where('client_id', $user->id)->get();
                $messages = [];
                foreach ($items as $message) {
                    $messages[] = [
                        'id' => $message['id'],
                        'user_id' => $message['user_id'],
                        'message' => $message['message'],
                        'image' => $message['image'],
                        'state' => $message['state'],
                        'created_at' => $message['created_at'],
                        'updated_at' => $message['updated_at'],
                    ];
                }
                return response()->json($messages);
            } else {
                return response('No Content', 204);
            }
        } else {
            return response('Unauthorized', 401);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            //TODO (Mejorar esta validación)
            'message' => ['required'],
            'client_id' => ['filled'],
            'image' => ['filled', 'image', 'between:3,4096'],
        ]);
        $data = $request->except('frontend_id');
        if ($request->exists('image')) {
            $path = $request->file('image')->store('messages', 'src');
            $data['image'] = $path;
        }
        //Verificar si el mensaje fue enviado por un usuario de soporte técnico desde la página o si fue
        //enviado por un cliente desde la aplicación
        if ($request->exists('client_id')) {
            $data['user_id'] = $request->user()->id;
        } else {
            $token = PersonalAccessToken::findToken(request()->bearerToken());
            if ($token) {
                $user = $token->tokenable;
                if ($user) {
                    $data['client_id'] = $user->id;
                } else {
                    return response('No Content', 204);
                }
            } else {
                return response('Unauthorized', 401);
            }
        }
        $message = Message::create($data);
        MessageSended::dispatch($message, $request->frontend_id);
        return response()->json($message);
    }

    /**
     * Marcar como leídos los mensajes pasados en los ids de la petición
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function read(Request $request)
    {
        // Obtener los ids del la petición
        $ids = Str::of($request->ids)->explode(',');
        Message::ids($ids)->update(['state' => 'seen']);
        return response('', 200);
    }

    /**
     * Eliminar registros de la base de datos a partir de los ids pasados en la petición
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //Obtener los ids del la petición
        $ids = Str::of($request->ids)->explode(',');
        Log::alert(json_encode($ids));
        $clientId = 0;
        foreach ($ids as $id) {
            //Recuperar el modelo
            $message = Message::find($id);
            //Eliminar el modelo si no es un mensaje de Soporte Técnico
            if ($message && $message->user_id !== null) {
                $result = $message->delete();
                //Verificar si se eliminó y eliminar la imagen anexada si existía
                if ($result == 1 && $message->image !== null) {
                    //Eliminar imagen anexada del mensaje
                    Storage::disk('src')->delete($message->image);
                }
                $clientId = $message->client_id;
            }
        }
        MessageRemoved::dispatch($ids, $clientId);
        return response('', 200);
    }
}
