<?php

namespace App\Http\Controllers;

use App\Service;
use App\MembershipPlan;
use Illuminate\Http\Request;

class CustomerHomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $services = Service::limit(6)->get();

        $plans = MembershipPlan::all();

        return view('customer-display.home', compact('services','plans'));
    }
}
