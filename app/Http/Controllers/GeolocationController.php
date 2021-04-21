<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeolocationController extends Controller
{
    public function index()
    {
        return view('geolocation.index');
    }
}
