<?php

namespace App\Console;

use App\Events\ButtonStateChanged;
use App\Models\Button;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $buttons = Button::all();
            foreach ($buttons as $button) {
                if (Carbon::now()->subMinutes(11) - Carbon::parse($button['last_connection']) > 0) {
                    if ($button['state'] == 'Connected') {
                        $item = Button::where('id', $button['id']);
                        $item->update([
                            'state' => 'Disconnected'
                        ]);
                        Notification::create([
                            'client_id' => $item->client_id,
                            'title' => 'Dispositivo desconectado',
                            'content' => "El dispositivo de %client% ha perdido la conexión Wi-Fi"
                        ]);
                        ButtonStateChanged::dispatch($button['id'], 'Disconnected');
                    }
                }
            }
        })->everyMinute();
        // $schedule->call(function () {
        //     Log::alert("sito");
        // })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
