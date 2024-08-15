<?php

namespace App\Http\Controllers\Space;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Space\StoreVenueRequest;
use App\SpaceBookingVenue;
use App\SpaceVenueEmail;
use App\DepartmentList;
use App\SpaceStatus;
use App\SpaceVenue;
use App\SpaceStaff;
use App\Staff;
use DataTables;
use Auth;

class VenueDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = SpaceStatus::Main()->get();
        $student = SpaceStatus::Student()->get();
        $department = DepartmentList::all();
        $check = SpaceStaff::StaffId(Auth::user()->id)->first();
        $staff = Staff::where('status_id',1)->get();
        if(isset($check)){
            $venue = SpaceVenue::with('spaceStatus','departmentList')
            ->where('department_id',$check->department_id)->select('space_venues.*');
        }else{
            $venue = SpaceVenue::with('spaceStatus','departmentList')->select('space_venues.*');
        }
        if($request->ajax()) {
        return DataTables::of($venue)
            ->addColumn('venue_status', function($venue){
                return isset($venue->spaceStatus->name) ? $venue->spaceStatus->name : '';
            })
            ->addColumn('open_to_student', function($venue){
                return isset($venue->openStudent->name) ? $venue->openStudent->name : '';
            })
            ->addColumn('department_name', function($venue){
                return isset($venue->departmentList->name) ? $venue->departmentList->name : '';
            })
            ->addColumn('action', function($venue){
                if($venue->spaceBookingVenues->count() >= 1){
                    return
                    '
                    <button class="btn btn-primary btn-sm edit_data" data-toggle="modal" data-id="'.$venue->id.'" id="edit" name="edit"><i class="fal fa-pencil"></i></button>
                    ';
                }else{
                    return
                    '
                    <button class="btn btn-primary btn-sm edit_data" data-toggle="modal" data-id="'.$venue->id.'" id="edit" name="edit"><i class="fal fa-pencil"></i></button>
                    <button class="btn btn-sm btn-danger btn-delete delete" data-remote="/space/venue-management/' . $venue->id . '"> <i class="fal fa-trash"></i></button>
                    ';
                }
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('space.venue.index',compact('venue','status','student','department','staff'));
    }

    public function getVenueDetail(Request $request)
    {
        $venue = SpaceVenue::find($request->id);
        echo json_encode($venue);
    }

    public function getVenueEmail($id)
    {
        $email = SpaceVenueEmail::VenueId($id)->get();

        $offer = $email->pluck('staff_id')->toArray();

        $interest = Staff::where('status_id',1)->get();

        return response()->json(compact('interest','offer'));
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
    public function store(StoreVenueRequest $request)
    {
        $venue_id = SpaceVenue::create([
            'name' => $request->name,
            'description' => $request->description,
            'minimum' => $request->minimum,
            'maximum' => $request->maximum,
            'open_student' => ($request->open_student == 'on') ? 7 : 8,
            'department_id' => $request->department_id,
            'status' => ($request->status == 'on') ? 1 : 2,
            'email_sent' => ($request->email_sent == 'on') ? 1 : 2,
        ]);

        if(isset($request->staff_id)){
            foreach($request->staff_id as $staffs_id){
                SpaceVenueEmail::create([
                    'venue_id' => $venue_id->id,
                    'staff_id' => $staffs_id,
                ]);
            }
        }

        return redirect()->back()->with('message','Created');
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
    public function update(StoreVenueRequest $request, $id)
    {
        $check = SpaceBookingVenue::where('venue_id',$request->venue_id)->count();
        $venue = SpaceVenue::find($request->venue_id);
        SpaceVenue::where('id',$request->venue_id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'maximum' => $request->maximum,
            'open_student' => ($request->open_student == 'on') ? 7 : 8,
            'department_id' => $request->department_id,
            'status' => ($request->status == 'on') ? 1 : 2,
            'email_sent' => ($request->email_sent == 'on') ? 1 : 2,
        ]);

        if(isset($request->staff_id)){
            SpaceVenueEmail::where('venue_id',$request->venue_id)
            ->whereNotIn('staff_id',$request->staff_id)->delete();
    
            foreach($request->staff_id as $staffs_id){
                SpaceVenueEmail::firstOrCreate([
                    'venue_id' => $request->venue_id,
                    'staff_id' => $staffs_id,
                ]);
            }
        }else{
            SpaceVenueEmail::where('venue_id',$request->venue_id)->delete();   
        }

        return redirect()->back()->with('message','Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SpaceVenue::where('id',$id)->delete();
    }
}
