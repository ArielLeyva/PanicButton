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
        $this->message = $message;
        $this->frontend_id = $frontend_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return ['message-channel'];
    }

    public function broadcastAs()
    {
        return 'MessageSended';
    }
}
