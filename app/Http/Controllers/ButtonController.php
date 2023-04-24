<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Button;
use Laravel\Sanctum\PersonalAccessToken;

class ButtonController extends Controller
{
    public function index()
    {
        return response()->json(Button::all());
    }

    public function getDevicesByClient(Request $request) {
        $token = PersonalAccessToken::findToken(request()->bearerToken());
        if($token) {
            $user = $token->tokenable;
            if($user) {
                $items = Button::where('client_id', $user->id)->get();
                $buttons = [];
                foreach($items as $button) {
                    $buttons[] = [
                        'id' => $button['id'],
                        'name' => $button['name'],
                        'number' => $button['number'],
                        'state' => $button['state'],
                        'coordinates' => $button['coordinates'],
                        'last_connection' => $button['last_connection'],
                        'created_at' => $button['created_at'],
                        'updated_at' => $button['updated_at'],
                    ];
                }
                return response()->json($buttons);
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
            'number' => ['required', 'regex:/^[A-Za-z0-9\-]+$/'],
            'state' => ['filled', 'in:Connected,Disconnected']
        ]);
        //Crear la instancia del modelo en la base de datos
        $data = $request->all();
        $data['last_connection'] = now()->toDateTimeString();
        $item = Button::create($data);
        //Retornar el nuevo modelo
        return response()->json($item);
    }

    /**
     * Eliminar registros de la base de datos a partir del id pasado en la petición
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = Button::destroy($id);
        if ($result) {
            return response('');
        } else {
            return response('No se pudo eliminar el botón', 422);
        }
    }

    public function unassign($id)
    {
        Button::find($id)->update(['client_id' => null]);
        return response('');
    }

    public function assign($id, $client)
    {
        $button = Button::find($id);
        $button->update(['client_id' => $client]);
        $button->refresh();
        return response()->json($button);
    }
}
