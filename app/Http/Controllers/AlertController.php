<?php

namespace App\Http\Controllers;

use App\Events\AlertPressed;
use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Models\Button;
use App\Models\Notification;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $separator = strpos($data['message']['text'], ':');
        $text = Str::of($data['message']['text']);
        $number = $text->substr(0, $separator);
        $type = $text->substr($separator + 1);
        $button = Button::where('number', $number)->first();
        $alert = Alert::create([
            'client_id' => $button->client_id,
            'type' => $type
        ]);
        Notification::create([
            'client_id' => $alert->client_id,
            'title' => 'Alerta presionada',
            'content' => '%client% ha presionado su botón de pánico con una alerta ' + $type == "Police" ? "Policial" : "Médica"
        ]);
        AlertPressed::dispatch($alert);
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
