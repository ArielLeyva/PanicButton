<?php

namespace App\Http\Controllers;

use App\Events\AlertPressed;
use App\Events\ButtonStateChanged;
use App\Http\Controllers\Controller;
use App\Jobs\SendFirebaseCloudMessage;
use App\Models\Alert;
use App\Models\Button;
use App\Models\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    public function index()
    {
        $alerts = Alert::all();
        $sort = $alerts->sortByDesc('created_at');
        return response()->json($sort->values()->all());
    }

    public function getClientAlerts()
    {
        $id = $this->getIdByToken();
        if ($id !== null) {
            $buttons = Button::where('client_id', $id)->get();
            $ids = Arr::pluck($buttons->toArray(), 'id');
            $items = Alert::buttons($ids)->get();
            $alerts = [];
            foreach ($items as $alert) {
                $alerts[] = Arr::except($alert->toArray(), ['button']);
            }
            return response()->json($alerts);
        } else {
            return response('No Content', 204);
        }
    }

    public function handle($message)
    {
        $separator = strpos($message, ':');
        $text = Str::of($message);
        $number = $separator === false ? $text : $text->substr(0, $separator);
        $type = $separator === false ? 'Health' : $text->substr($separator + 1);
        $button = Button::where('number', $number)->first();
        if ($button !== null) {
            if ($type == 'Online') {
                $this->state($button);
            } else if ($button->on) {
                $this->store($button, $type);
            }
        }
        return response('');
    }

    public function store(Button $button, $type)
    {
        //Registrar alerta
        $alert = Alert::create([
            'button_id' => $button->id,
            'type' => $type
        ]);
        $type = $type == "Police" ? "Policial" : "Médica";
        if ($alert->button->client_id == null) {
            Notification::create([
                'client_id' => $alert->button->client_id,
                'title' => 'Alerta emitida',
                'content' => 'Se ha emitido un alerta de un dispositivo sin vincular'
            ]);
        } else {
            Notification::create([
                'client_id' => $alert->button->client_id,
                'title' => 'Alerta emitida',
                'content' => "Se ha emitido un alerta del dispositivo {$alert->button->name} ({$alert->button->number})"
            ]);
        }
        AlertPressed::dispatch($alert);
        SendFirebaseCloudMessage::dispatch($alert);
    }

    private function state(Button $button)
    {
        //Actualizar estado
        $updated = [
            'last_connection' => now()->toDateTimeString()
        ];
        if ($button->state == 'Disconnected') {
            $updated['state'] = 'Connected';
            Notification::create([
                'client_id' => $button->client_id,
                'title' => 'Dispositivo conectado',
                'content' => "El dispositivo {$button->name} ({$button->number}) ha retomado la conexión Wi-Fi"
            ]);
            ButtonStateChanged::dispatch($button->id, 'Connected');
        }
        $button->update($updated);
    }

    public function readed(Request $request, $id)
    {
        $alert = Alert::find($id);
        //Crear la instancia del modelo en la base de datos
        if ($request->path() == 'api/client') {
            if ($alert->button->client_id != $this->getIdByToken()) {
                return response('Unauthorized', 401);
            } else {
                $alert->update(['state' => 'Descartada']);
            }
        } else {
            $alert->update(['state' => 'Vista']);
        }
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
