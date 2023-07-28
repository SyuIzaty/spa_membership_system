<?php

namespace App\Http\Controllers\Space;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\SpaceBookingVenue;
use App\SpaceStatus;
use App\SpaceVenue;

class BookingReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $venue = SpaceVenue::Active()->get();
        $status = SpaceStatus::Application()->get();
        return view('space.booking-report.index',compact('request','venue','status'));
    }

    public function data_exportbooking(Request $request)
    {
        $cond = $cond_main = "1";

        if($request->from && $request->from != "All")
        {
            $cond_main .= " AND (start_date = '".$request->from."')";
        }

        if($request->to && $request->to != "All")
        {
            $cond_main .= " AND (end_date = '".$request->to."')";
        }
        
        if($request->venue && $request->venue != "All")
        {
            $cond .= " AND (venue_id = '".$request->venue."')";
        }

        $cat = $request->category;

        $venue = SpaceBookingVenue::whereRaw($cond)
        ->wherehas('spaceBookingMain',function($query) use ($cond_main){
            $query->whereRaw($cond_main);
        })
        ->with('spaceBookingMain','spaceBookingMain.user','spaceVenue')
        ->get();

        return datatables()::of($venue)
            ->addColumn('user_id',function($venue)
            {
                return isset($venue->spaceBookingMain->staff_id) ? Str::title($venue->spaceBookingMain->staff_id) : '';
            })
            ->addColumn('user_name',function($venue)
            {
                return isset($venue->spaceBookingMain->user->name) ? Str::title($venue->spaceBookingMain->user->name) : '';
            })
            ->addColumn('user_category',function($venue)
            {
                return isset($venue->spaceBookingMain->user->category) ? ($venue->spaceBookingMain->user->category) : '';
            })
            ->addColumn('venue',function($venue)
            {
                return isset($venue->spaceVenue->name) ? Str::title($venue->spaceVenue->name) : '';
            })
            ->addColumn('user_start',function($venue)
            {
                return isset($venue->spaceBookingMain->start_date) ? ($venue->spaceBookingMain->start_date) : '';
            })
            ->addColumn('user_end',function($venue)
            {
                return isset($venue->spaceBookingMain->end_date) ? ($venue->spaceBookingMain->end_date) : '';
            })
            ->addColumn('time_start',function($venue)
            {
                return isset($venue->spaceBookingMain->start_time) ? ($venue->spaceBookingMain->start_time) : '';
            })
            ->addColumn('time_end',function($venue)
            {
                return isset($venue->spaceBookingMain->end_time) ? ($venue->spaceBookingMain->end_time) : '';
            })
            ->addColumn('status',function($venue)
            {
                return isset($venue->spaceStatus->name) ? ($venue->spaceStatus->name) : '';
            })
           ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
