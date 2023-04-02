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
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller
{
    public function handle(Request $request)
    {
        $data = $request->all();
        Log::alert(json_encode($request->all()));
        if (isset($data['text'])) {
            if ($data['text'] !== "/start") {
                $separator = strpos($data['text'], ':');
                $text = Str::of($data['text']);
                $number = $separator === false ? $text->substr(1) : $text->substr(1, $separator);
                $type = $separator === false ? 'Health' : $text->substr($separator + 1);
                $button = Button::where('number', $number)->first();
                Log::alert($type);
                if ($button !== null && $button->client_id !== null) {
                    if ($type == 'Online') {
                        $this->updateState($button);
                        //Eliminar mensaje de Telegram
                        // $token = env('TELEGRAM_TOKEN');
                        // $chat = env('TELEGRAM_CHAT_ID');
                        // $message = $data['message']['message_id'];
                        // $url = "https://api.telegram.org/bot{$token}/deleteMessage?chat_id={$chat}&message_id={$message}";
                        // $ch = curl_init();
                        // curl_setopt($ch, CURLOPT_URL, $url);
                        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        // curl_setopt($ch, CURLOPT_TIMEOUT, 20);
                        // curl_exec($ch);
                        // curl_close($ch);
                    } else {
                        $this->createAlert($button, $type);
                    }
                }
            }
        }
    }

    private function updateState(Button $button)
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
        Log::alert("Button state changed");
    }

    private function createAlert(Button $button, $type)
    {
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
