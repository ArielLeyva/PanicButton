<?php

namespace App\Jobs;

use App\Models\Alert;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Factory;

class AlertSentNotify implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Alert $alert)
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
        if ($this->alert->button->client_id !== null) {
            $message = CloudMessage::fromArray([
                'topic' => "alert_sent_{$this->alert->button->client_id}",
                'notification' => ['title' => 'Alerta presionada', 'body' => "El dispositivo {$this->alert->button->name} ha detectado un movimiento"],
                'data' => [
                    'event' => 'alert_sent',
                    'content' => json_encode($this->alert->toArray()),
                ],
                "content_available" => true,
                "priority" => "high"
            ]);
            $messaging->send($message);
        }
    }
}
