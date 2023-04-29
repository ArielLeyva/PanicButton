<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::all()->groupBy('client_id');
        $sort = $messages->sortByDesc('created_at');
        return response()->json($sort->values()->all());
    }

    public function store(Request $request)
    {
        $request->validate([
            //TODO (Mejorar esta validación)
            'message' => ['required'],
            'client_id' => ['required'],
        ]);
        $data = $request->except('frontend_id');
        $data['user_id'] = $request->user()->id;
        $message = Message::create($data);
        $json = $message->toArray();
        $json['frontend_id'] = $request->frontend_id;
        return response()->json($json);
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
        foreach ($ids as $id) {
            //Recuperar el modelo
            $message = Message::find($id);
            //Eliminar el modelo si no es un mensaje de Soporte Técnico
            if ($message->user !== null) {
                // MessageDeleted::dispatch($message);
                $result = $message->delete();
                //Verificar si se eliminó y eliminar la imagen anexada si existía
                if ($result == 1 && $message->annexed !== null) {
                    //Eliminar imagen anexada del mensaje
                    // Storage::disk('images')->delete($message->annexed);
                }
            }
        }
        return response('', 200);
    }
}
