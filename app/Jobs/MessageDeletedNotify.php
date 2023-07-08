<?php

namespace App\Jobs;

use App\Models\Button;
use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Factory;

class MessageDeletedNotify implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public $ids, public $id)
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
        $title = count($this->ids) == 1 ? 'Mensaje eliminado' : 'Mensajes eliminados';
        $body = count($this->ids) == 1 ? 'Un mensaje ha sido eliminado eliminado' : 'Varios mensajes fueron eliminados';
        $message = CloudMessage::fromArray([
            'topic' => "message_deleted_{$this->id}",
            'notification' => ['title' => $title, 'body' => $body],
            'data' => [
                'event' => 'message_deleted',
                'content' => json_encode(['ids' => $this->ids]),
            ],
            "content_available" => true,
            "priority" => "high"
        ]);
        $messaging->send($message);
    }
}
