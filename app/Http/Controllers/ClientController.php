<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Button;
use App\Models\Client;
use App\Models\TelephoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Kreait\Firebase\Factory;

class ClientController extends Controller
{
    public function index()
    {
        return response()->json(Client::all());
    }

    public function getAuthClient()
    {
        $client = $this->_getAuthClient();
        if ($client !== null) {
            if ($client !== false) {
                return response()->json($client);
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
            'name' => ['required', 'between:3,60'],
            'dni' => ['required', 'regex:/^[0-9]+$/'],
            'gender' => ['required', 'in:Femenino,Masculino'],
            'state' => ['required', 'in:Activo,Inactivo']
        ]);
        $factory = (new Factory)->withServiceAccount(base_path() . '/' . env('FIREBASE_CREDENTIALS', '/config/firebase_auth_file.json'));
        $auth = $factory->createAuth();
        $firebaseUser = $auth->createUserWithEmailAndPassword($request->email, 'gWCXR3Y8');
        $data = $request->except(['address', 'telephone_numbers', 'avatar']);
        $item = Client::create($data);
        $numbers = $request->telephone_numbers;
        foreach ($numbers as $number) {
            TelephoneNumber::create(['number' => $number, 'client_id' => $item->id]);
        }
        //Crear la instancia del modelo en la base de datos
        $address = Address::create($request->address);
        $item->address_id = $address->id;
        $item->update();
        $item->refresh();
        $auth->updateUser($firebaseUser->uid, [
            'displayName' => $item->name,
            'photoUrl' => $item->avatarPath,
        ]);
        //Retornar el nuevo modelo
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            //TODO (Mejorar esta validación)
            'name' => ['required', 'between:3,60'],
            'dni' => ['required', 'regex:/^[0-9]+$/'],
            'gender' => ['required', 'in:Femenino,Masculino'],
            'state' => ['filled', 'in:Activo,Inactivo']
        ]);
        //Crear la instancia del modelo en la base de datos
        $client = Client::find($id);
        if ($this->isClientRequest($request)) {
            if ($client->id != $this->getIdByToken() || $request->has('state')) {
                return response('Unauthorized', 401);
            }
        }
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

    public function updateAvatar(Request $request, $id)
    {
        $client = Client::find($id);
        if ($client->id != $this->getIdByToken() || $request->has('state')) {
            return response('Unauthorized', 401);
        } else {
            if ($request->has('avatar')) {
                $image = $request->input('avatar');
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $name = time() . '.png';
                Storage::disk('src')->put("users/$name", base64_decode($image));
                $client->avatar = "users/$name";
                $client->update();
                $client->refresh();
                return response()->json($client);
            }
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
        Button::where('client_id', $id)->update(['client_id' => null]);

        $client = Client::find($id);
        if ($client->avatar !== null) {
            Storage::disk('src')->delete($client->avatar);
        }
        $result = $client->delete();
        if ($result) {
            return response('');
        } else {
            return response('No se pudo eliminar el cliente', 422);
        }
    }
}
