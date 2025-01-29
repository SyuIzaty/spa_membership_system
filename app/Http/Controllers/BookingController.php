<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use DataTables;
use App\Staff;
use App\Booking;
use App\BookingStatus;
use App\BookingStatusTrack;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $statuses = BookingStatus::all();

        $staffs = Staff::whereNull('staff_end_date')->whereHas('user', function($query){
            $query->where('role_id', 'SPA002');
        })->get();


        $check = Staff::where('user_id', Auth::user()->id)->whereNull('staff_end_date')->whereHas('user', function($query){
            $query->where('role_id', 'SPA002');
        })->first();

        if(isset($check)){

            $booking = Booking::where('staff_id', $check->user_id)->get();

        } else {

            $booking = Booking::all();
        }

        if($request->ajax()) {

            return DataTables::of($booking)

                ->addColumn('id', function($booking){

                    return isset($booking->id) ? $booking->id : '';
                })

                ->addColumn('customer_id', function($booking){

                    return isset($booking->customer->customer_name) ? $booking->customer->customer_name : '';
                })

                ->addColumn('staff_id', function($booking){

                    return isset($booking->staff->staff_name) ? $booking->staff->staff_name : '';
                })

                ->addColumn('booking_date', function($booking){

                    return isset($booking->booking_date) ? $booking->booking_date : '';
                })

                ->addColumn('booking_time', function($booking){

                    return isset($booking->booking_time) ? $booking->booking_time : '';
                })

                ->addColumn('booking_status', function($booking){

                    return isset($booking->bookingStatus->status_name) ? $booking->bookingStatus->status_name : '';
                })

                ->addColumn('booking_payment_status', function($booking){

                    return isset($booking->booking_payment_status) ? $booking->booking_payment_status : '';
                })

                ->addColumn('service_id', function($booking){

                    return isset($booking->service_id) ? $booking->service_id : '';
                })

                ->editColumn('created_at', function ($booking) {

                    return $booking->created_at;
                })

                ->addColumn('action', function($booking){
                    return
                    '<div class="btn-group">
                            <a href="/list-booking/'.$booking->id.'/edit" class="btn btn-primary btn-sm edit_data"><i class="fal fa-pencil"></i></a>
                        </div>';
                })

                ->rawColumns(['action','id','customer_id','staff_id','booking_date','booking_time','booking_status','booking_payment_status','service_id','created_at'])
                ->make(true);
        }

        return view('admin-display.booking',compact('statuses','staffs','booking'));
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
        $request->validate([
            'booking_id'            => 'required',
            'booking_status'        => 'required',
            'staff_id'              => 'required',
        ]);

        $booking = Booking::where('id', $request->booking_id)->first();

        $booking->update([
            'booking_status'    => $request->booking_status,
            'staff_id'          => $request->staff_id,
        ]);

        BookingStatusTrack::create([
            'booking_id'            => $booking->id,
            'booking_status_id'     => $booking->booking_status,
            'created_by'            => Auth::user()->id,
        ]);

        Session::flash('message', 'Booking updated successfully.');

        return redirect()->back();
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
