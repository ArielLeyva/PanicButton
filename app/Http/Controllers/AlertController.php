<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alert;

class AlertController extends Controller
{
    public function index()
    {
        return response()->json(Alert::all());
    }
}
