<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Http\Controllers\Controller;
use App\Models\Button;
use Laravel\Sanctum\PersonalAccessToken;

class ButtonController extends Controller
{
    public function index()
    {
        return response()->json(Button::all());
    }

    public function getDevicesByClient(Request $request)
    {
        $id = $this->getIdByToken();
        if ($id !== null) {
            $items = Button::where('client_id', $id)->get();
            $buttons = [];
            foreach ($items as $button) {
                $buttons[] = Arr::except($button->toArray(), ['client_id', 'client']);
            }
            return response()->json($buttons);
        } else {
            return response('No Content', 204);
        }
    }

    public function store(Request $request)
    {

        $request->validate([
            //TODO (Mejorar esta validación)
            'name' => ['filled', 'regex:/^[A-Za-z0-9\- ]+$/'],
            'number' => ['required', 'regex:/^[A-Za-z0-9\-]+$/'],
            'coordinates' => ['filled'],
            'client_id' => ['filled', 'exists:clients,id'],
            'state' => ['filled', 'in:Connected,Disconnected']
        ]);
        //Crear la instancia del modelo en la base de datos
        if ($request->path() == 'api/client/devices') {
            if ($request->exists('client_id')) {
                if ($request->client_id != $this->getIdByToken()) {
                    return response('Unauthorized', 401);
                }
            } else {
                return response('', 422);
            }
        }
        $data = $request->all();
        $data['last_connection'] = now()->toDateTimeString();
        $item = Button::create($data);
        //Retornar el nuevo modelo
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            //TODO (Mejorar esta validación)
            'name' => ['required', 'regex:/^[A-Za-z0-9\- ]+$/'],
            'number' => ['required', 'regex:/^[A-Za-z0-9\-]+$/'],
            'coordinates' => ['required']
        ]);
        $button = Button::find($id);
        //Crear la instancia del modelo en la base de datos
        if ($request->path() == 'api/client/devices') {
            if ($button->client_id != $this->getIdByToken()) {
                return response('Unauthorized', 401);
            }
        }
        $data = $request->except('_method');
        $button->update($data);
        //Retornar el nuevo modelo
        return response()->json($button);
    }

    public function power($id)
    {
        $button = Button::find($id);
        $id = $this->getIdByToken();
        if ($id == $button->client_id) {
            $button->on = !$button->on;
            $button->save();
            return response()->json($button);
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
    public function destroy(Request $request, $id)
    {
        $button = Button::find($id);
        //Crear la instancia del modelo en la base de datos
        if ($request->path() == 'api/client/devices') {
            if ($button->client_id != $this->getIdByToken()) {
                return response('Unauthorized', 401);
            }
        }
        $result = $button->delete();
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
