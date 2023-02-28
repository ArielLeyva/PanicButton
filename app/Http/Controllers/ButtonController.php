<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Button;

class ButtonController extends Controller
{
    public function index()
    {
        return response()->json(Button::all()->groupBy('state'));
    }
}
