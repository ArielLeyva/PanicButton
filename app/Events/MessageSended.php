<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSended implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public $frontend_id;

    /**
     * Create a new event instance.
     */
    public function __construct($message, $frontend_id)
    {
        $data = $message->get();
        $this->message = [
            'id' => $message->id,
            'client_id' => $message->client_id,
            'user_id' => $message->user_id,
            'message' => $message->message,
            'image' => $message->image,
            'state' => $message->state,
            'created_at' => $message->created_at,
            'updated_at' => $message->updated_at,
        ];
        $this->frontend_id = $frontend_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return ['message-channel', "client-message-channel-" . $this->message['client_id']];
    }

    public function broadcastAs()
    {
        return 'MessageSended';
    }
}
