<?php

namespace App\Http\Controllers\ShortCourseManagement\EventManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShortCourseManagement\Event;
use App\Models\ShortCourseManagement\Venue;
use App\Models\ShortCourseManagement\ShortCourse;
use App\Models\ShortCourseManagement\Trainer;
use App\Models\ShortCourseManagement\Fee;
use App\Models\ShortCourseManagement\EventTrainer;
use App\Models\ShortCourseManagement\EventShortCourse;
use App\Models\ShortCourseManagement\Topic;
use App\User;
use Auth;
use File;

class EventController extends Controller
{
    public function index()
    {
        return view('short-course-management.event-management.index');
    }

    public function dataEventManagement()
    {
        $events = Event::all()->load(['events_participants', 'venue']);
        $index = 0;
        foreach ($events as $event) {
            if (isset($event->events_participants)) {
                $totalValidParticipants = $event->events_participants->where('is_approved', 1)->count();
                $totalParticipantsNotApprovedYet = $event->events_participants->where('is_approved', 0)->where('is_done_email_cancellation_disqualified', 0)->count();
                $totalRejected = $event->events_participants->where('is_done_email_cancellation_disqualified', 1)->count();
            } else {
                $totalValidParticipants = 0;
                $totalParticipantsNotApprovedYet = 0;
                $totalRejected = 0;
            }
            $events[$index]->totalValidParticipants = $totalValidParticipants;
            $events[$index]->totalParticipantsNotApprovedYet = $totalParticipantsNotApprovedYet;
            $events[$index]->totalRejected = $totalRejected;
            $index++;
        }
        return datatables()::of($events)
            ->addColumn('dates', function ($events) {
                return 'Date Start: ' . $events->datetime_start . '<br> Date End:' . $events->datetime_end;
            })
            ->addColumn('participant', function ($events) {
                return 'Total Valid: ' . $events->totalValidParticipants . '<br> Total Not Approved Yet:' . $events->totalParticipantsNotApprovedYet . '<br> Total Reject:' . $events->totalRejected;
            })
            ->addColumn('management_details', function ($events) {
                return 'Created By: ' . $events->created_by . '<br> Created At: ' . $events->created_at;
            })
            ->addColumn('action', function ($events) {
                return '
                <a href="/event/' . $events->id . '/events-participants/show" class="btn btn-sm btn-primary">Participants</a>
                <a href="/event/' . $events->id . '" class="btn btn-sm btn-primary">Settings</a>';
            })
            ->rawColumns(['action', 'management_details', 'participant', 'dates'])
            ->make(true);
    }
    public function create()
    {
        //


        $venues = Venue::all();

        $shortcourses = ShortCourse::all();

        $topics = Topic::all();


        return view('short-course-management.event-management.create', compact('venues','shortcourses', 'topics'));
    }
    public function storeNew(Request $request)
    {
        //
    }
    function show($id)
    {

        $event = Event::find($id)->load([
            'events_participants',
            'venue',
            'events_shortcourses.shortcourse',
            'events_trainers.trainer',
            'fees'
        ]);


        $venues = Venue::all();

        $shortcourses = ShortCourse::all();

        // $trainers = array();
        foreach ($event->events_trainers as $event_trainer){
            $event_trainer->trainer->user=User::find($event_trainer->trainer->user_id);
        }
        // dd($event);
        //
        return view('short-course-management.event-management.show', compact('event','venues','shortcourses'));
    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        //
        $validated = $request->validate([
            'name' => 'required|max:255',
            'datetime_start' => 'required',
            'datetime_end' => 'required',
            'venue' => 'required',
        ], [
            'name.required' => 'Please insert event name',
            'name.max' => 'Name exceed maximum length',
            'datetime_start.required' => 'Please insert event datetime start',
            'datetime_end.required' => 'Please insert event datetime end',
            'venue.required' => 'Please insert event venue',
        ]);

        $update = Event::find($id)->update([
            'name' => $request->name,
            'datetime_start' => $request->datetime_start,
            'datetime_end' => $request->datetime_end,
            'venue_id' => $request->venue,
        ]);

        return Redirect()->back()->with('messageEventBasicDetails', 'Basic Details Update Successfully');
    }
    public function updateFee(Request $request, $id)
    {
        // dd($request);
        // //
        $validated = $request->validate([
            'name_fee_edit' => 'required|max:255',
            'amount' => 'required',
            'is_base_fee_select_edit' => 'required',
        ], [
            'name_fee_edit.required' => 'Please insert fee name',
            'name_fee_edit.max' => 'Name exceed maximum length',
            'amount.required' => 'Please insert fee amount',
            'is_base_fee_select_edit.required' => 'Please insert fee type',
        ]);

        if($request->is_base_fee_select_edit==0){
            $promo_code=$request->promo_code;
        }else{
            $promo_code=null;
        }

        $update = Fee::find($request->id)->update([
            'is_base_fee' => $request->is_base_fee_select_edit,
            'promo_code' =>$promo_code,
            'promo_end_datetime'=>null,
            'name' => $request->name_fee_edit,
            'event_id' => $id,
            'amount' => $request->amount,
            'updated_by' =>Auth::user()->id,
            'is_active' => 1,
        ]);

        return Redirect()->back()->with('messageEventBasicDetails', 'Basic Details Update Successfully');
    }

    public function storeFee(Request $request, $id)
    {
        // dd($request);
        // //
        $validated = $request->validate([
            'name' => 'required|max:255',
            'amount' => 'required',
            'is_base_fee_select_add' => 'required',
        ], [
            'name.required' => 'Please insert fee name',
            'name.max' => 'Name exceed maximum length',
            'amount.required' => 'Please insert fee amount',
            'is_base_fee_select_add.required' => 'Please insert fee type',
        ]);

        if($request->is_base_fee_select_add==0){
            $promo_code=$request->promo_code_add;
        }else{
            $promo_code=null;
        }

        $create = Fee::create([
            'is_base_fee' => $request->is_base_fee_select_add,
            'promo_code' =>$promo_code,
            'promo_end_datetime'=>null,
            'name' => $request->name,
            'event_id' => $id,
            'amount' => $request->amount,
            'created_by' =>Auth::user()->id,
            'is_active' => 1,
        ]);

        return Redirect()->back()->with('messageEventBasicDetails', 'Basic Details Update Successfully');
    }



    public function deleteFee($fee_id)
    {

        $exist = Fee::find($fee_id);
        $exist->updated_by = Auth::user()->id;
        $exist->deleted_by = Auth::user()->id;
        $exist->save();
        $exist->delete();

        return Redirect()->back()->with('messageEventBasicDetails', 'Basic Details Update Successfully');
    }

    public function detachedTrainer($EventTrainer_id)
    {

        $exist = EventTrainer::find($EventTrainer_id);
        $exist->updated_by = Auth::user()->id;
        $exist->deleted_by = Auth::user()->id;
        $exist->save();
        $exist->delete();

        return Redirect()->back()->with('messageEventBasicDetails', 'Basic Details Update Successfully');
    }

    public function detachedShortCourse($EventShortCourse_id)
    {

        $exist = EventShortCourse::find($EventShortCourse_id);
        $exist->updated_by = Auth::user()->id;
        $exist->deleted_by = Auth::user()->id;
        $exist->save();
        $exist->delete();

        return Redirect()->back()->with('messageEventBasicDetails', 'Basic Details Update Successfully');
    }

    public function storeTrainer(Request $request, $id)
    {
        // dd($request);
        // //
        $validated = $request->validate([
            'trainer_id' => 'required',
        ], [
            'trainer_id.required' => 'Please insert user id of the trainer',
        ]);

        $create = EventTrainer::create([
            'event_id' => $id,
            'trainer_id' => $request->trainer_id,
            'is_done_paid' => 0,
            'trainer_representative_id' => $request->trainer_id,
            'created_by' =>Auth::user()->id,
            'is_active' => 1,
        ]);


        return Redirect()->back()->with('messageEventBasicDetails', 'Basic Details Update Successfully');
    }
    public function storeShortCourse(Request $request, $id)
    {
        // dd($request);
        // //
        $validated = $request->validate([
            'shortcourse_id' => 'required',
        ], [
            'shortcourse_id.required' => 'Please insert atleast a short course',
        ]);

        $create = EventShortCourse::create([
            'event_id' => $id,
            'shortcourse_id' => $request->shortcourse_id,
            'created_by' =>Auth::user()->id,
            'is_active' => 1,
        ]);

        return Redirect()->back()->with('messageEventBasicDetails', 'Basic Details Update Successfully');
    }
    public function destroy($id)
    {
        //
    }

    //Public View

    public function indexPublicView()
    {
        $events = Event::all()->load(['events_participants', 'venue', 'fees']);
        $index=0;
        foreach($events as $event){
            $events[$index]->created_at_diffForHumans=$events[$index]->created_at->diffForHumans();
            $index++;

        }
        return view('short-course-management.public-view.main.index', compact('events'));

        // return view('short-course-management.event-management.index');
    }

    public function getFile($file)
    {
        // $path = storage_path().'/'.'app'.'/'.'shortcourse'.'/'.'system'.'/'.$file;
        $path = asset('/'.'storage'.'/'.'app'.'/'.'shortcourse'.'/'.'system'.'/'.$file) ;

        // dd($path);

        $file = File::get($path);
        $filetype = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $filetype);

        return $response;
    }

    function showPublicView($id)
    {

        $event = Event::find($id)->load([
            'events_participants',
            'venue',
            'events_shortcourses.shortcourse',
            'events_trainers.trainer',
            'fees'
        ]);

        //
        return view('short-course-management.public-view.main.show', compact('event'));
    }

    public function dataPublicView()
    {
        $events = Event::all()->load(['events_participants', 'venue']);
        $index = 0;
        foreach ($events as $event) {
            if (isset($event->events_participants)) {
                $totalValidParticipants = $event->events_participants->where('is_approved', 1)->count();
                $totalParticipantsNotApprovedYet = $event->events_participants->where('is_approved', 0)->where('is_done_email_cancellation_disqualified', 0)->count();
                $totalRejected = $event->events_participants->where('is_done_email_cancellation_disqualified', 1)->count();
            } else {
                $totalValidParticipants = 0;
                $totalParticipantsNotApprovedYet = 0;
                $totalRejected = 0;
            }
            $events[$index]->totalValidParticipants = $totalValidParticipants;
            $events[$index]->totalParticipantsNotApprovedYet = $totalParticipantsNotApprovedYet;
            $events[$index]->totalRejected = $totalRejected;
            $index++;
        }
        return datatables()::of($events)
            ->addColumn('name-with-href', function ($events) {
                return '
                <a href="/event/public-view/'. $events->id .'" class="text-primary">'.$events->name.'</a>';
            })
            ->addColumn('dates', function ($events) {
                return 'Date Start: ' . $events->datetime_start . '<br> Date End:' . $events->datetime_end;
            })
            ->rawColumns(['name-with-href', 'dates'])
            ->make(true);
    }
}
