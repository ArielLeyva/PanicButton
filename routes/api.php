<?php

use App\Http\Controllers\AlertController;
use App\Http\Controllers\ButtonController;
use App\Http\Controllers\ClientController;
use Illuminate\Http\Request;
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


Route::resource('/buttons', ButtonController::class)->only([
    'store', 'index', 'update'
]);
Route::resource('/clients', ClientController::class)->only([
    'store', 'index', 'update'
]);
Route::resource('/alerts', AlertController::class)->only([
    'store', 'index', 'update'
]);
