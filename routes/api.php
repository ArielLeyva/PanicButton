<?php

use App\Http\Controllers\AlertController;
use App\Http\Controllers\ButtonController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Button;
use App\Http\Controllers\ClientAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('/buttons', ButtonController::class)->only([
        'store',
        'index',
        'update',
        'destroy'
    ]);
    Route::put('/buttons/unassign/{id}', [ButtonController::class, 'unassign']);
    Route::put('/buttons/assign/{id}/{client}', [ButtonController::class, 'assign']);

    Route::resource('/clients', ClientController::class)->only([
        'store',
        'index',
        'update',
        'destroy'
    ]);

    Route::resource('/alerts', AlertController::class)->only([
        'store',
        'index',
        'destroy'
    ]);
    Route::put('/alerts/readed/{id}', [AlertController::class, 'readed']);

    Route::get('/notifications', [NotificationController::class, 'index']);

    Route::put('/messages/read', [MessageController::class, 'read']);
    Route::resource('/messages', MessageController::class)->only([
        'store',
        'index',
        'update',
    ]);
    Route::delete('/messages', [MessageController::class, 'destroy']);

});


Route::get('/client/messages', [MessageController::class, 'getClientMessages']);
Route::post('/client/messages', [MessageController::class, 'store']);
Route::get('/client/notifications', [NotificationController::class, 'getClientNotifications']);

Route::get("/lksiw2assol25sdpl548/{message}", [AlertController::class, 'handle']);

Route::post('client/login', [ClientAuthController::class, 'authenticate']);

Route::get("/client/user", [ClientController::class, 'getClientByToken']);

Route::get("/client/alerts", [AlertController::class, 'getAlertsByClient']);

Route::get("/client/devices", [ButtonController::class, 'getDevicesByClient']);
