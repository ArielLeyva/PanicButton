<?php

namespace App\Listeners;

use App\Events\ButtonStateChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ButtonStateChangedNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ButtonStateChanged $event): void
    {
        //
    }
}
