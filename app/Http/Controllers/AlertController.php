<?php

namespace App\Http\Controllers;

use App\Events\AlertPressed;
use App\Events\ButtonStateChanged;
use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Models\Button;
use App\Models\Notification;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    public function index()
    {
        $alerts = Alert::all();
        $sort = $alerts->sortByDesc('created_at');
        return response()->json($sort->values()->all());
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if (isset($data['message']['text'])) {
            if ($data['message']['text'] !== "/start") {
                $separator = strpos($data['message']['text'], ':');
                $text = Str::of($data['message']['text']);
                $number = $separator === false ? $text : $text->substr(0, $separator);
                $type = $separator === false ? 'Health' : $text->substr($separator + 1);
                $button = Button::where('number', $number)->first();
                if ($button !== null && $button->client_id !== null) {
                    if ($type == 'Online') {
                        //Actualizar estado
                        $updated = [
                            'last_connection' => now()->toDateTimeString()
                        ];
                        if ($button->state == 'Disconnected') {
                            $updated['state'] = 'Connected';
                            Notification::create([
                                'client_id' => $button->client_id,
                                'title' => 'Dispositivo conectado',
                                'content' => "El dispositivo de %client% ha retomado la conexión Wi-Fi"
                            ]);
                            ButtonStateChanged::dispatch($button->id, 'Connected');
                        }
                        $button->update($updated);
                    } else {
                        //Registrar alerta
                        $alert = Alert::create([
                            'client_id' => $button->client_id,
                            'type' => $type
                        ]);
                        $type = $type == "Police" ? "Policial" : "Médica";
                        Notification::create([
                            'client_id' => $alert->client_id,
                            'title' => 'Alerta presionada',
                            'content' => "%client% ha presionado su botón de pánico con una alerta $type"
                        ]);
                        AlertPressed::dispatch($alert);
                    }
                }
            }
        }
    }

    public function readed($id)
    {
        Alert::find($id)->update(['state' => 'Vista']);
        return response('');
    }

    /**
     * Eliminar registros de la base de datos a partir del id pasado en la petición
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = Alert::destroy($id);
        if ($result) {
            return response('');
        } else {
            return response('No se pudo eliminar la alerta', 422);
        }
    }
}
