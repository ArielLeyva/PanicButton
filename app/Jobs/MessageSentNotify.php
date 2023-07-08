<?php

namespace App\Jobs;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Factory;

class MessageSentNotify implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Message $message, public $frontendId)
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
            'topic' => "message_sent_{$this->message->client_id}",
            'notification' => ['title' => 'Nuevo mensaje de soporte', 'body' => $this->message->message],
            'data' => [
                'event' => 'message_sent',
                'content' => json_encode($this->message->toArray()),
                'frontend_id' => $this->frontendId,
            ],
            "content_available" => true,
            "priority" => "high"
        ]);
        $messaging->send($message);
    }
}
