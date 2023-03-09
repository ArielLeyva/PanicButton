<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Client;
use App\Models\TelephoneNumber;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        return response()->json(Client::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            //TODO (Mejorar esta validación)
            'name' => ['required', 'between:3,60'],
            'dni' => ['required', 'integer'],
            'birthdate' => ['required', 'date'],
            'gender' => ['required', 'in:Femenino,Masculino'],
            'state' => ['required', 'in:Activo,Bloqueado']
        ]);
        //Crear la instancia del modelo en la base de datos
        $address = Address::create($request->address);
        $data = $request->except(['address', 'telephone_numbers', 'avatar']);
        //TODO (Modificar)
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('users', 'src');
            $data['avatar'] = $path;
        }
        $data['address_id'] = $address->id;
        $item = Client::create($data);
        $numbers = $request->telephone_numbers;
        foreach ($numbers as $number) {
            TelephoneNumber::create(['number' => $number, 'client_id' => $item->id]);
        }
        $item->refresh();
        //Retornar el nuevo modelo
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            //TODO (Mejorar esta validación)
            'name' => ['required', 'between:3,60'],
            'dni' => ['required', 'integer'],
            'birthdate' => ['required', 'date'],
            'gender' => ['required', 'in:Femenino,Masculino'],
            'state' => ['required', 'in:Activo,Bloqueado']
        ]);
        //Crear la instancia del modelo en la base de datos
        $client = Client::find($id);
        $address = Address::find($client->address_id);
        $address->update($request->address);
        $data = $request->except(['address', 'telephone_numbers', 'avatar', '_method']);
        if ($request->hasFile('avatar')) {
            //TODO (Eliminar archivo viejo)
            $path = $request->file('avatar')->store('users', 'src');
            $data['avatar'] = $path;
        }
        $client->update($data);
        TelephoneNumber::where('client_id', $client->id)->delete();
        $numbers = $request->telephone_numbers;
        foreach ($numbers as $number) {
            TelephoneNumber::create(['number' => $number, 'client_id' => $client->id]);
        }
        $client->refresh();
        //Retornar el nuevo modelo
        return response()->json($client);
    }

    /**
     * Eliminar registros de la base de datos a partir del id pasado en la petición
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = Client::destroy($id);
        if ($result) {
            return response('');
        } else {
            return response('No se pudo eliminar el botón', 422);
        }
    }
}
