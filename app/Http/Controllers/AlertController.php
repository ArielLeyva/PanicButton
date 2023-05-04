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
use Laravel\Sanctum\PersonalAccessToken;

class AlertController extends Controller
{
    public function index()
    {
        $alerts = Alert::all();
        $sort = $alerts->sortByDesc('created_at');
        return response()->json($sort->values()->all());
    }

    public function getAlertsByClient(Request $request)
    {
        $token = PersonalAccessToken::findToken(request()->bearerToken());
        if ($token) {
            $user = $token->tokenable;
            if ($user) {
                // $sort = Alert::where('button.client_id', $user->id)->get()->sortByDesc('created_at');
                $buttons = Button::where('client_id', $user->id)->get();
                $ids = [];
                foreach ($buttons as $button) {
                    $ids[] = $button['id'];
                }
                $sort = Alert::buttons($ids)->get()->sortByDesc('created_at');
                $alerts = [];
                foreach ($sort as $alert) {
                    $alerts[] = [
                        'id' => $alert['id'],
                        'type' => $alert['type'],
                        'state' => $alert['state'],
                        'created_at' => $alert['created_at']
                    ];
                }
                return response()->json($alerts);
            } else {
                return response('No Content', 204);
            }
        } else {
            return response('Unauthorized', 401);
        }
    }

    public function handle(Request $request, $message)
    {
        $separator = strpos($message, ':');
        $text = Str::of($message);
        $number = $separator === false ? $text : $text->substr(0, $separator);
        $type = $separator === false ? 'Health' : $text->substr($separator + 1);
        $button = Button::where('number', $number)->first();
        if ($button !== null) {
            if ($type == 'Online') {
                $this->state($button);
            } else {
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
                'title' => 'Alerta presionada',
                'content' => 'Se ha presionado la alerta de un dispositivo sin vincular'
            ]);
        } else {
            Notification::create([
                'client_id' => $alert->button->client_id,
                'title' => 'Alerta presionada',
                'content' => "%client% ha presionado su botón de pánico con una alerta $type"
            ]);
        }
        AlertPressed::dispatch($alert);
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
                'content' => "El dispositivo de %client% ha retomado la conexión Wi-Fi"
            ]);
            ButtonStateChanged::dispatch($button->id, 'Connected');
        }
        $button->update($updated);
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
