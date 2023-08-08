<?php

namespace App\Http\Controllers\Space;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Space\StoreBookingManagementRequest;
use Illuminate\Support\Facades\Mail;
use App\Rules\SpaceBookingRule;
use App\SpaceBookingMain;
use App\SpaceBookingItem;
use App\SpaceBookingVenue;
use App\SpaceStatus;
use App\SpaceVenue;
use App\SpaceItem;
use App\Student;
use App\Staff;
use App\User;
use DataTables;
use Validator;
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
        $venue = SpaceBookingVenue::with('spaceBookingMain.user','spaceVenue')
        ->select('space_booking_venues.*');
        
        if($request->ajax()) {
            return DataTables::of($venue)
                ->addColumn('user_ids', function($venue){
                    return isset($venue->spaceBookingMain->user->id) ? $venue->spaceBookingMain->user->id : '';
                })
                ->addColumn('user_names', function($venue){
                    return isset($venue->spaceBookingMain->user->name) ? $venue->spaceBookingMain->user->name : '';
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
                ->editColumn('created_at', function ($venue) {
                    return $venue->created_at;
                })
                ->addColumn('action', function($venue){
                    return
                    '
                    <div class="btn-group">
                    <a href="/space/booking-management/'.$venue->id.'/edit" class="btn btn-primary btn-sm edit_data"><i class="fal fa-pencil"></i></a>
                    <a href="/space/booking/'.$venue->id.'" class="btn btn-success btn-sm edit_data" target="_blank"><i class="fal fa-file-pdf"></i></a>
                    <button class="btn btn-sm btn-danger btn-delete delete" data-remote="/space/booking-management/' . $venue->id . '"> <i class="fal fa-trash"></i></button>
                    </div>
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
        $student = Student::where('students_status','AKTIF')->pluck('students_id')->toArray();
        $staff = Staff::pluck('staff_id')->toArray();
        $all_active = array_merge($student,$staff);
        $user = User::whereIn('id',$all_active)->get();
        $venue = SpaceVenue::Active()->get();
        $item = SpaceItem::Active()->get();

        return view('space.booking-management.create',compact('user','venue','item'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookingManagementRequest $request)
    {
        $rules = [
            'user_id' => ['required',new SpaceBookingRule($request->all())]
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
                'staff_id' => $request->user_id,
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
                        'application_status' => 3,
                        'verify_by' => Auth::user()->id
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
        $user = User::find(isset($main->spaceBookingMain->staff_id) ? $main->spaceBookingMain->staff_id : '');
        $status = SpaceStatus::where('category','Application')->get();
        return view('space.booking-management.edit',compact('main','status','user'));
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
            'booking_id' => 'required',
            'application_status' => 'required',
        ]);

        SpaceBookingVenue::where('id',$request->booking_id)->update([
            'application_status' => $request->application_status,
            'verify_by' => Auth::user()->id,
        ]);

        
        if($request->application_status == 3){
            $booking_venue = SpaceBookingVenue::find($request->booking_id);
            $main = SpaceBookingMain::find($booking_venue->space_main_id);
            $user = User::find($main->staff_id);
            $user_email = $user->email;

            $data = [
                'receivers'   => $user->name,
                'departDate'  => date(' d/m/Y ', strtotime($main->start_date)),
                'departTime'  => date(' h:i A ', strtotime($main->start_time)),
                'returnDate'  => date(' d/m/Y ', strtotime($main->end_date)),
                'returnTime'  => date(' h:i A ', strtotime($main->end_time)),
                'destination' => isset($booking_venue->spaceVenue->name) ? $booking_venue->spaceVenue->name : '',
                'purpose'     => $main->purpose,
                'footer'      => 'Kerjasama daripada pihak Tuan/Puan amat kami hargai. Terima Kasih',
            ];

            Mail::send('space.booking-management.email', $data, function ($message) use ($user_email) {
                $message->subject('LIBRARY: TEMPAHAN RUANG');
                $message->from('library@intec.edu.my');
                $message->to($user_email);
            });
        }


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
        $venue = SpaceBookingVenue::where('id',$id)->first();
        SpaceBookingVenue::where('id',$id)->delete();
        $total_venue = SpaceBookingVenue::where('space_main_id',$venue->space_main_id)->get();
        if($total_venue->count() < 1){
            SpaceBookingMain::where('id',$venue->space_main_id)->delete();
            SpaceBookingItem::where('space_main_id',$venue->space_main_id)->delete();
        }
    }
}
