<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Button;

class ButtonController extends Controller
{
    public function index()
    {
        return response()->json(Button::all()->groupBy('state'));
    }

    public function store(Request $request)
    {
        $request->validate([
            //TODO (Mejorar esta validación)
            'number' => ['required', 'integer'],
            'state' => ['filled', 'in:Connected,Disconnected']
        ]);
        //Crear la instancia del modelo en la base de datos
        $data = $request->all();
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

    public function unasign($id)
    {
        Button::find($id)->update(['client_id' => null]);
        return response('');
    }

    public function asign($id, $client)
    {
        $button = Button::find($id);
        $button->update(['client_id' => $client]);
        $button->refresh();
        return response()->json($button);
    }
}
