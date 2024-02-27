<?php

namespace App\Http\Controllers;

use App\eKenderaan;
use App\eKenderaanAssignDriver;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EKenderaanCalendarController extends Controller
{
    public function index()
    {
        $driver = eKenderaanAssignDriver::get();

        return view('eKenderaan.calendar', compact('driver'));
    }

}
