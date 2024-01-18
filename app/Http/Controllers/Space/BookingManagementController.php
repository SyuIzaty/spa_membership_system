<?php

namespace App\Http\Controllers\Space;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Space\StoreBookingManagementRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Rules\SpaceBookingRule;
use App\SpaceAttachment;
use App\SpaceBookingMain;
use App\SpaceBookingItem;
use App\SpaceBookingVenue;
use App\SpaceStatus;
use App\SpaceVenue;
use App\SpaceStaff;
use App\DepartmentList;
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
        $status = SpaceStatus::where('category','Application')->get();
        $check = SpaceStaff::StaffId(Auth::user()->id)->first();
        if(isset($check)){
            $booking = SpaceBookingVenue::with('spaceBookingMain')
            ->wherehas('spaceVenue',function($query) use ($check){
                $query->where('department_id',$check->department_id);
            })->get();
            $venue = SpaceBookingVenue::with('spaceBookingMain.user','spaceVenue')
            ->wherehas('spaceVenue',function($query) use ($check){
                $query->where('department_id',$check->department_id);
            })
            ->select('space_booking_venues.*');
            $total = SpaceBookingVenue::with('spaceBookingMain.user','spaceVenue')
            ->wherehas('spaceVenue',function($query) use ($check){
                $query->where('department_id',$check->department_id);
            })
            ->get();
        }else{
            $booking = SpaceBookingVenue::with('spaceBookingMain')->get();
            $venue = SpaceBookingVenue::with('spaceBookingMain.user','spaceVenue','spaceStatus')
            ->select('space_booking_venues.*');
            $total = SpaceBookingVenue::with('spaceBookingMain.user','spaceVenue','spaceStatus')->get();
        }
        // dd($venue->where('application_status',3)->get()->count());
        
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
                ->addColumn('status_name', function($venue){
                    return isset($venue->spaceStatus->name) ? $venue->spaceStatus->name : '';
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
                ->rawColumns(['action','status_name'])
                ->make(true);
        }

        return view('space.booking-management.index',compact('booking','status','venue','total'));
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
        $check = SpaceStaff::StaffId(Auth::user()->id)->first();
        if(isset($check)){
            $venue = SpaceVenue::Active()->where('department_id',$check->department_id)->get();
            $item = SpaceItem::Active()->where('department_id',$check->department_id)->get();
        }else{
            $venue = SpaceVenue::Active()->get();
            $item = SpaceItem::Active()->get();
        }

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
                'no_user' => $request->no_user,
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
    
            if(isset($request->checks)){
                foreach($request->checks as $key_item => $value_item){
                    if($value_item != null){
                        SpaceBookingItem::create([
                            'space_main_id' => $booking,
                            'item_id' => $key_item,
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
        $attachment = SpaceAttachment::MainId($id)->first();
        return Storage::disk('minio')->response('booking-attachment/'.$attachment->file_name);
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
        $venue_department = SpaceVenue::find($main->venue_id);
        $venue = SpaceVenue::DepartmentId($venue_department->department_id)->get();
        $user = User::find(isset($main->spaceBookingMain->staff_id) ? $main->spaceBookingMain->staff_id : '');
        $status = SpaceStatus::where('category','Application')->get();
        $attachment = SpaceAttachment::MainId($main->space_main_id)->first();
        return view('space.booking-management.edit',compact('main','status','user','venue','venue_department','attachment'));
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
            // 'venue_id' => $request->venue,
            'application_status' => $request->application_status,
            'verify_by' => Auth::user()->id,
        ]);
        
        $booking_venue = SpaceBookingVenue::find($request->booking_id);
        $main = SpaceBookingMain::find($booking_venue->space_main_id);
        $user = User::find($main->staff_id);
        $user_email = $user->email;
        $venue_main = SpaceVenue::find($booking_venue->venue_id);

        if($request->application_status == 3){

            $data = [
                'receivers'   => $user->name,
                'departDate'  => date(' d/m/Y ', strtotime($main->start_date)),
                'departTime'  => date(' h:i A ', strtotime($main->start_time)),
                'returnDate'  => date(' d/m/Y ', strtotime($main->end_date)),
                'returnTime'  => date(' h:i A ', strtotime($main->end_time)),
                'destination' => isset($booking_venue->spaceVenue->name) ? $booking_venue->spaceVenue->name : '',
                'purpose'     => $main->purpose,
                'departmentName' => isset($venue_main->departmentList->name) ? $venue_main->departmentList->name : '',
                'departmentPhone' => isset($venue_main->departmentList->phone) ? $venue_main->departmentList->phone : '',
                'footer'      => 'Kerjasama daripada pihak Tuan/Puan amat kami hargai. Terima Kasih',
            ];

            Mail::send('space.booking-management.email', $data, function ($message) use ($user_email,$venue_main) {
                $message->subject(isset($venue_main->departmentList->name) ? $venue_main->departmentList->name : ''.': TEMPAHAN RUANG');
                $message->from(isset($venue_main->departmentList->email) ? $venue_main->departmentList->email : '');
                $message->to($user_email);
            });
        }
        if($request->application_status == 4){

            $data = [
                'receivers'   => $user->name,
                'departDate'  => date(' d/m/Y ', strtotime($main->start_date)),
                'destination' => isset($booking_venue->spaceVenue->name) ? $booking_venue->spaceVenue->name : '',
                'purpose'     => $main->purpose,
                'footer'      => 'Kerjasama daripada pihak Tuan/Puan amat kami hargai. Terima Kasih',
            ];

            Mail::send('space.booking-management.rejected-email', $data, function ($message) use ($user_email,$venue_main) {
                $message->subject(isset($venue_main->departmentList->name) ? $venue_main->departmentList->name : ''.': TEMPAHAN RUANG');
                $message->from(isset($venue_main->departmentList->email) ? $venue_main->departmentList->email : '');
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
