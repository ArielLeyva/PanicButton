<?php

use App\Events\ButtonStateChanged;
use App\Http\Controllers\AuthController;
use App\Models\Alert;
use App\Models\Button;
use App\Models\Notification;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('dashboard');
    Route::get('/dashboard', function () {
        return view('welcome');
    });
    Route::get('logout', [AuthController::class, 'logout']);
});

Route::get('/login', function () {
    return view('login');
})->name('login');



Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/state', function () {
    $buttons = Button::all();
    foreach ($buttons as $button) {
        $current = Carbon::now()->subMinutes(11);
        $lastConnection = Carbon::parse($button['last_connection']);
        if ($lastConnection->lessThan($current)) {
            if ($button['state'] == 'Connected') {
                $item = Button::where('id', $button['id'])->first();
                $item->update([
                    'state' => 'Disconnected'
                ]);
                Notification::create([
                    'client_id' => $item->client_id,
                    'title' => 'Dispositivo desconectado',
                    'content' => "El dispositivo " . $button['name'] . " (" . $button['number'] . ") ha perdido la conexión Wi-Fi"
                ]);
                ButtonStateChanged::dispatch($button['id'], 'Disconnected');
            }
        }
    }
});
