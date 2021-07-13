<?php

namespace App\Http\Controllers;

use Artisan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        Artisan::call('cache:clear');
        return view('home');
    }
}
