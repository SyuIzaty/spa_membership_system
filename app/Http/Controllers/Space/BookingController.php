<?php

namespace App\Http\Controllers\Space;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Space\StoreBookingRequest;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade as PDF;
use App\Rules\SpaceBookingRule;
use App\Rules\UpdateSpaceBookingRule;
use App\SpaceBookingVenue;
use App\SpaceBookingMain;
use App\SpaceBookingItem;
use App\SpaceVenue;
use App\SpaceItem;
use App\User;
use DataTables;
use Validator;
use Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $venue = SpaceBookingVenue::wherehas('spaceBookingMain',function($query){
            $query->where('staff_id',Auth::user()->id);
        })
        ->with('spaceBookingMain','spaceVenue','spaceStatus')
        ->select('space_booking_venues.*');
        
        if($request->ajax()) {
            return DataTables::of($venue)
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
                ->addColumn('statuses', function($venue){
                    return isset($venue->spaceStatus->name) ? $venue->spaceStatus->name : '';
                })
                ->addColumn('action', function($venue){
                    if($venue->application_status == 5){
                        return
                        '
                        <a href="/space/booking/'.$venue->id.'/edit" class="btn btn-primary btn-sm edit_data"><i class="fal fa-pencil"></i></a>
                        <a href="/space/booking/'.$venue->id.'" class="btn btn-success btn-sm edit_data" target="_blank"><i class="fal fa-file-pdf"></i></a>
                        <button class="btn btn-sm btn-danger btn-delete delete" data-remote="/space/booking/' . $venue->id . '"> <i class="fal fa-trash"></i></button>
                        ';
                    }
                    if($venue->application_status != 5){
                        return
                        '
                        <a href="/space/booking/'.$venue->id.'" class="btn btn-success btn-sm edit_data" target="_blank"><i class="fal fa-file-pdf"></i></a>
                        ';
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('space.booking.index',compact('venue'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = User::find(Auth::user()->id);
        if($user->category == 'STD'){
            $venue = SpaceVenue::Active()->Student()->get();
        }else{
            $venue = SpaceVenue::Active()->get();
        }
        $item = SpaceItem::Active()->get();
        return view('space.booking.create',compact('user','venue','item'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookingRequest $request)
    {
        $rules = [
            'purpose' => ['required',new SpaceBookingRule($request->all())]
        ];
        $message = [];
        $validator = Validator::make($request->all(),$rules,$message);

        if($validator->fails()){
            return back()->withInput()->withErrors($validator->errors());
        }

        if(!isset($request->venue)){
            $message = 'Select at least one venue';
            $stat = 'error';
        }else{
            $booking = SpaceBookingMain::insertGetId([
                'staff_id' => Auth::user()->id,
                'user_phone' => $request->phone_number,
                'user_office' => $request->office_no,
                'purpose' => $request->purpose,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'remark' => $request->remark,
            ]);
    
            if(isset($request->venue)){
                foreach($request->venue as $key => $value){
                    SpaceBookingVenue::create([
                        'space_main_id' => $booking,
                        'venue_id' => $key,
                        'application_status' => 5,
                    ]);
                }
            }
    
            if(isset($request->unit)){
                foreach($request->unit as $key_item => $value_item){
                    if($value_item != null){
                        SpaceBookingItem::create([
                            'space_main_id' => $booking,
                            'item_id' => $key_item,
                            'unit' => $request->unit[$key_item],
                        ]);
                    }
                }
            }

            $data = [
                'receivers'   => 'INTEC Library User',
                'footer'      => 'Kerjasama daripada pihak Tuan/Puan amat kami hargai. Terima Kasih',
            ];

            Mail::send('space.booking.application-email', $data, function ($message) {
                $message->subject('LIBRARY: PERMOHONAN TEMPAHAN RUANG');
                $message->from(Auth::user()->email);
                $message->to('inteclibraryuser@intec.edu.my');
            });

            $message = 'Application Sent';
            $stat = 'success';
        }

        return redirect()->back()->with($stat, $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $booking = SpaceBookingVenue::find($id);
        $booking_item = SpaceBookingItem::MainId($booking->space_main_id)->get();
        $venue = SpaceVenue::Active()->get();
        $item = SpaceItem::Active()->get();
        $user = User::find(isset($booking->spaceBookingMain->staff_id) ? $booking->spaceBookingMain->staff_id : Auth::user()->id);
        $pdf = PDF::loadView('space.booking.show', compact('booking','user','venue','item','booking_item'));
        return $pdf->stream('Booking.pdf');
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
        $venue = SpaceVenue::Active()->get();
        $item = SpaceItem::Active()->get();
        $user = User::find(isset($main->spaceBookingMain->staff_id) ? $main->spaceBookingMain->staff_id : Auth::user()->id);
        $booking_item = SpaceBookingItem::MainId($main->space_main_id)->pluck('item_id')->toArray();

        return view('space.booking.edit',compact('main','venue','item','booking_item','user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBookingRequest $request, $id)
    {
        $request->merge(['id' => $id]);
        $rules = [
            'purpose' => ['required',new UpdateSpaceBookingRule($request->all())]
        ];
        $message = [];
        $validator = Validator::make($request->all(),$rules,$message);

        if($validator->fails()){
            return back()->withInput()->withErrors($validator->errors());
        }

        $venue = SpaceBookingVenue::find($id);
        if(!isset($request->venue)){
            $message = 'Select at least one venue';
            $stat = 'error';
        }else{
            SpaceBookingMain::where('id',$venue->space_main_id)->update([
                'staff_id' => Auth::user()->id,
                'user_phone' => $request->phone_number,
                'user_office' => $request->office_no,
                'purpose' => $request->purpose,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'remark' => $request->remark,
            ]);

            SpaceBookingVenue::where('id',$id)->update([
                'venue_id' => $request->venue,
            ]);


            if(isset($request->unit)){
                foreach($request->unit as $key_item => $value_item){
                    if($value_item != null){
                        SpaceBookingItem::updateOrCreate([
                            'space_main_id' => $venue->space_main_id,
                            'item_id' => $key_item,
                        ],[
                            'unit' => $request->unit[$key_item],
                        ]);
                    }
                }
            }

            $message = 'Application Updated';
            $stat = 'success';
        }

        return redirect()->back()->with($stat, $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $venue = SpaceBookingVenue::where('id',$id)->first();
        SpaceBookingVenue::where('id',$id)->delete();
        $total_venue = SpaceBookingVenue::where('space_main_id',$venue->space_main_id)->get();
        if($total_venue->count() < 1){
            SpaceBookingMain::where('id',$venue->space_main_id)->delete();
            SpaceBookingItem::where('space_main_id',$venue->space_main_id)->delete();
        }
    }
}
