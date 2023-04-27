<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Models\Message;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::all()->groupBy('client_id');
        $sort = $messages->sortByDesc('created_at');
        return response()->json($sort->values()->all());
    }
}
