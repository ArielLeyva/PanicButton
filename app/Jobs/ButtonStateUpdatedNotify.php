<?php

namespace App\Jobs;

use App\Models\Button;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Factory;

class ButtonStateUpdatedNotify implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Button $button)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $factory = (new Factory)->withServiceAccount(base_path() . '/' . env('FIREBASE_CREDENTIALS', '/config/firebase_auth_file.json'));
        $messaging = $factory->createMessaging();
        $title = $this->button->state == 'Connected' ? 'Alarma conectada' : 'Alarma desconectada';
        $body = $this->button->state == 'Connected' ? "El dispositivo {$this->button->name} ha retomado la conexión Wi-Fi" : "El dispositivo {$this->button->name} ha perdido la conexión Wi-Fi";
        if ($this->button->client_id !== null) {
            $message = CloudMessage::fromArray([
                'topic' => "device_state_changed_{$this->button->client_id}",
                'notification' => ['title' => $title, 'body' => $body],
                'data' => [
                    'event' => 'device_state_changed',
                    'content' => json_encode($this->button->toArray()),
                ],
                "content_available" => true,
                "priority" => "high"
            ]);
            $messaging->send($message);
        }
    }
}
