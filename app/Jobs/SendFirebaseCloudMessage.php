<?php

namespace App\Jobs;

use App\Models\Alert;
use App\Models\Button;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Factory;

class SendFirebaseCloudMessage implements ShouldQueue
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
        $message = CloudMessage::fromArray([
            'topic' => "app_fcm_client_{$this->alert->button->client_id}",
            'notification' => ['title' => 'Alerta presionada', 'body' => "El dispositivo {$this->alert->button->name} ha detectado un movimiento"],
            'data' => ['button_id' => $this->alert->button->id],
            "content_available" => true,
            "priority" => "high"
        ]);
        $result = $messaging->send($message);
        Log::alert(json_encode($result));
    }
}
