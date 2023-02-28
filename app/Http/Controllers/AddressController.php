<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Address;

class AddressController extends Controller
{
    public function index()
    {
        return response()->json(Address::all());
    }
}
