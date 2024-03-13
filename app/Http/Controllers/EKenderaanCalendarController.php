<?php

namespace App\Http\Controllers;

use App\eKenderaanAssignDriver;
use App\Http\Controllers\Controller;

class EKenderaanCalendarController extends Controller
{
    public function index()
    {
        $driver = eKenderaanAssignDriver::with('details', 'driverList', 'vehicles.vehicleList')->get();

        return view('eKenderaan.calendar', compact('driver'));
    }

}
