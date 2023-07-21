<?php

namespace App\Http\Controllers\Space;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SpaceBookingMain;
use App\SpaceBookingItem;
use App\SpaceBookingVenue;
use App\SpaceStatus;
use App\SpaceVenue;
use App\SpaceItem;
use DataTables;
use Auth;

class BookingManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $booking = SpaceBookingVenue::with('spaceBookingMain')->get();
        $status = SpaceStatus::where('category','Application')->get();
        $venue = SpaceBookingVenue::with('spaceBookingMain.staff','spaceBookingMain','spaceVenue')
        ->select('space_booking_venues.*');
        
        if($request->ajax()) {
            return DataTables::of($venue)
                ->addColumn('staff_ids', function($venue){
                    return isset($venue->spaceBookingMain->staff_id) ? $venue->spaceBookingMain->staff_id : '';
                })
                ->addColumn('staff_names', function($venue){
                    return isset($venue->spaceBookingMain->staff->staff_name) ? $venue->spaceBookingMain->staff->staff_name : '';
                })
                ->addColumn('purposes', function($venue){
                    return isset($venue->spaceBookingMain->purpose) ? $venue->spaceBookingMain->purpose : '';
                })
                ->addColumn('start_dates', function($venue){
                    return isset($venue->spaceBookingMain->start_date) ? $venue->spaceBookingMain->start_date : '';
                })
                ->addColumn('end_dates', function($venue){
                    return isset($venue->spaceBookingMain->end_date) ? $venue->spaceBookingMain->end_date : '';
                })
                ->addColumn('start_times', function($venue){
                    return isset($venue->spaceBookingMain->start_time) ? $venue->spaceBookingMain->start_time : '';
                })
                ->addColumn('end_times', function($venue){
                    return isset($venue->spaceBookingMain->end_time) ? $venue->spaceBookingMain->end_time : '';
                })
                ->addColumn('venues', function($venue){
                    return isset($venue->spaceVenue->name) ? $venue->spaceVenue->name : '';
                })
                ->addColumn('action', function($venue){
                    return
                    '
                    <a href="/space/booking-management/'.$venue->id.'/edit" class="btn btn-primary btn-sm edit_data"><i class="fal fa-pencil"></i></a>
                    <button class="btn btn-sm btn-danger btn-delete delete" data-remote="/space/booking-management/' . $venue->id . '"> <i class="fal fa-trash"></i></button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('space.booking-management.index',compact('booking','status','venue'));
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
        $request->validate([
            'booking_id' => 'required',
            'application_status' => 'required',
        ]);

        SpaceBookingVenue::where('id',$request->booking_id)->update([
            'application_status' => $request->application_status,
        ]);

        return redirect()->back()->with('message','Status Update');

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
        $main = SpaceBookingVenue::find($id);
        $status = SpaceStatus::where('category','Application')->get();
        return view('space.booking-management.edit',compact('main','status'));
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
        SpaceBookingVenue::where('id',$id)->update([
            'application_status' => $request->application_status,
            'verify_by' => Auth::user()->id,
        ]);

        return redirect()->back()->with('message','Updated');
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
