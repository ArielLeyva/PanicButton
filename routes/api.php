<?php

use App\Http\Controllers\AlertController;
use App\Http\Controllers\ButtonController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\NotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

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
        'store', 'index', 'update', 'destroy'
    ]);
    Route::put('/buttons/unasign/{id}', [ButtonController::class, 'unasign']);
    Route::put('/buttons/asign/{id}/{client}', [ButtonController::class, 'asign']);

    Route::resource('/clients', ClientController::class)->only([
        'store', 'index', 'update', 'destroy'
    ]);

    Route::resource('/alerts', AlertController::class)->only([
        'store', 'index', 'destroy'
    ]);
    Route::put('/alerts/readed/{id}', [AlertController::class, 'readed']);

    Route::get('/notifications', [NotificationController::class, 'index']);
});

Route::post("/lksiw2assol25sdpl548", [AlertController::class, 'store']);
