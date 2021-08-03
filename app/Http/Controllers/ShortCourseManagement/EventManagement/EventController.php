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
use App\Models\ShortCourseManagement\TopicShortCourse;
use App\Models\ShortCourseManagement\Topic;
use App\User;
use Auth;
use File;
use DateTime;
use Validator;

class EventController extends Controller
{
    public function index()
    {
        return view('short-course-management.event-management.index');
    }

    public function dataEventManagement()
    {
        $events = Event::orderByDesc('id')->get()->load(['events_participants', 'venue']);
        $index = 0;
        foreach ($events as $event) {
            if (isset($event->events_participants)) {
                $totalValidParticipants = $event->events_participants
                    ->where('event_id', $event->id)
                    ->where('is_approved_application', 1)
                    ->where('is_verified_payment_proof', 1)
                    ->where('is_verified_payment_proof', 1)
                    ->where('is_verified_approved_participation', 1)
                    ->where('is_disqualified', 0)
                    ->count();
                $totalParticipantsNotApprovedYet = $event->events_participants
                    ->where('event_id', $event->id)
                    ->where('is_approved_application', 0)
                    ->where('is_disqualified', 0)
                    ->count();
                $totalRejected = $event->events_participants
                    ->where('event_id', $event->id)
                    ->where('is_disqualified', 1)
                    ->count();
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

        $users = User::all();


        return view('short-course-management.event-management.create', compact('venues', 'shortcourses', 'topics', 'users'));
    }
    public function storeNew(Request $request)
    {
        //


        Validator::extend('check_array', function ($attribute, $value, $parameters, $validator) {
            return count($value) >= 1;
        });

        // dd($request);

        $validated = $request->validate([
            'shortcourse_id' => 'required',
            'shortcourse_name' => 'required|min:3',
            'shortcourse_description' => 'required|min:3',
            'shortcourse_objective' => 'required|min:3',
            'shortcourse_topic'  => 'check_array',
            'datetime_start' => 'required',
            'datetime_end' => 'required',
            'venue_id' => 'required',
            'venue_name' => 'required|min:3',
            'fee_name' => 'required|min:3',
            'fee_id' => 'required',
            'fee_amount' => 'required|numeric',
            'trainer_ic' => 'required',
            'trainer_fullname' => 'required|min:3',
            'trainer_phone' => 'required|min:10',
            'trainer_email' => 'required|email:rfc',

        ], [
            'shortcourse_id.required' => 'Please choose short course of the event',
            'shortcourse_name.required' => 'Please insert short course name',
            'shortcourse_name.min' => 'The name should have at least 3 characters',
            'shortcourse_description.required' => 'Please insert short course description',
            'shortcourse_description.min' => 'The description should have at least 3 characters',
            'shortcourse_objective.required' => 'Please insert short course objective',
            'shortcourse_objective.min' => 'The objective should have at least 3 characters',
            'shortcourse_topic.check_array' => 'Please insert at least one topic',
            'datetime_start.required' => 'Please insert event datetime start',
            'datetime_end.required' => 'Please insert event datetime end',
            'venue_id.required' => 'Please choose event venue',
            'venue_name.required' => 'Please insert venue name',
            'venue_name.min' => 'The name should have at least 3 characters',
            'fee_name.required' => 'Please insert fee name',
            'fee_name.min' => 'The name should have at least 3 characters',
            'fee_id.required' => 'Please insert fee id',
            'fee_amount.required' => 'Please insert fee amount',
            'fee_amount.numeric' => 'Please insert number only',
            'trainer_ic.required' => 'Please insert trainer IC',
            'trainer_fullname.required' => "Please insert trainer's fullname",
            'trainer_fullname.min' => "The trainer's fullname should have at least 3 characters",
            'trainer_phone.required' => "Please insert trainer's phone number",
            'trainer_phone.min' => "The trainer's phone number should have at least 10 numbers",
            'trainer_email.required' => "Please insert trainer's email",

        ]);

        $updateShortCourse = ShortCourse::find($request->shortcourse_id)->update([
            'name' => $request->shortcourse_name,
            'shortcourse_description' => $request->shortcourse_description,
            'shortcourse_objective' => $request->shortcourse_objective,
            'updated_by' => Auth::user()->id,
        ]);

        if (isset($request->shortcourse_topic)) {
            foreach ($request->shortcourse_topic as $shortcourse_topic) {
                $exist = TopicShortCourse::where([
                    ['shortcourse_id', '=', $request->shortcourse_id],
                    ['topic_id', '=', $shortcourse_topic],
                ])->get();

                if (!$exist) {
                    $createTopicShortCourse = TopicShortCourse::create([
                        'topic_id' => $shortcourse_topic,
                        'shortcourse_id' => $request->shortcourse_id,
                        'created_by' => Auth::user()->id,
                    ]);
                }
            }
        }



        $updateVenue = Venue::find($request->venue_id)->update([
            'name' => $request->venue_name,
            'updated_by' => Auth::user()->id,
        ]);

        $createEvent = Event::create([
            'name' => $request->shortcourse_name,
            'description' => $request->shortcourse_description,
            'objective' => $request->shortcourse_objective,
            'datetime_start' => $request->datetime_start,
            'datetime_end' => $request->datetime_end,
            'registration_due_date' => $request->datetime_start,
            'venue_id' => $request->venue_id,
            'created_by' => Auth::user()->id,
        ]);

        $createEventShortCourse = EventShortCourse::create([
            'event_id' => $createEvent->id,
            'shortcourse_id' => $request->shortcourse_id,
            'created_by' => Auth::user()->id,
        ]);


        $createFee = Fee::create([
            'is_base_fee' => $request->fee_id,
            'name' => $request->fee_name,
            'amount' => $request->fee_amount,
            'event_id' => $createEvent->id,
            'created_by' => Auth::user()->id,
        ]);


        $existTrainer = Trainer::where('ic', '=', $request->trainer_ic)->first();

        if (!$existTrainer) {
            $existUser = User::find($request->trainer_user_id)->first();
            if (!$existUser) {
                //CreateUser
            }
            $existTrainer = Trainer::create([
                'user_id' => $existUser->id,
                'ic' => $request->trainer_ic,
                'phone' => $request->trainer_phone,
                'created_by' => Auth::user()->id,
            ]);
        }

        $createEventTrainer = EventTrainer::create([
            'event_id' => $createEvent->id,
            'trainer_id' => $existTrainer->id,
            'trainer_representative_id' => $existTrainer->id,
            'phone' => $request->trainer_phone,
            'created_by' => Auth::user()->id,
        ]);

        // Redirect to show
        $event = Event::find($createEvent->id)->load([
            'events_participants',
            'venue',
            'events_shortcourses.shortcourse',
            'events_trainers.trainer',
            'fees'
        ]);


        $venues = Venue::all();

        $shortcourses = ShortCourse::all();

        // $trainers = array();
        foreach ($event->events_trainers as $event_trainer) {
            $event_trainer->trainer->user = User::find($event_trainer->trainer->user_id);
        }
        // dd($event);
        //
        // return view('short-course-management.event-management.show', compact('event','venues','shortcourses'));

        return Redirect('/event/' . $event->id)->with(compact('event', 'venues', 'shortcourses'));
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

        // $totalParticipantsNotApprovedYet = $event->events_participants->where('is_approved', 0)->where('is_done_email_cancellation_disqualified', 0)->count();

        $statistics['wait_for_application_approval'] = $event->events_participants
            ->where('event_id', $id)
            ->where('is_approved_application', 0)
            ->where('is_disqualified', 0)
            ->count();

        $statistics['wait_for_applicant_making_payment'] = $event->events_participants
            ->where('event_id', $id)
            ->where('is_approved_application', 1)
            ->where('is_verified_payment_proof', null)
            ->where('is_disqualified', 0)
            ->count();

        $statistics['wait_for_payment_verification'] = $event->events_participants
            ->where('event_id', $id)
            ->where('is_approved_application', 1)
            ->where('is_verified_payment_proof', 0)
            ->where('is_verified_payment_proof', 0)
            ->where('is_disqualified', 0)
            ->count();

        $statistics['ready_for_event'] = $event->events_participants
            ->where('event_id', $id)
            ->where('is_approved_application', 1)
            ->where('is_verified_payment_proof', 1)
            ->where('is_verified_payment_proof', 1)
            ->where('is_verified_approved_participation', 1)
            ->where('is_disqualified', 0)
            ->count();

        $statistics['attended_participant'] = $event->events_participants
            ->where('event_id', $id)
            ->where('is_approved_application', 1)
            ->where('is_verified_payment_proof', 1)
            ->where('is_verified_payment_proof', 1)
            ->where('is_disqualified', 0)
            ->where('is_not_attend', 0)
            ->count();

        $statistics['not_attended_participant'] = $event->events_participants
            ->where('event_id', $id)
            ->where('is_approved_application', 1)
            ->where('is_verified_payment_proof', 1)
            ->where('is_verified_payment_proof', 1)
            ->where('is_disqualified', 0)
            ->where('is_not_attend', 1)
            ->count();

        $statistics['cancelled_application'] = $event->events_participants
            ->where('event_id', $id)->where('is_disqualified', 1)->count();

        $statistics['not_completed_feedback'] = $event->events_participants
            ->where('event_id', $id)
            ->where('is_approved_application', 1)
            ->where('is_verified_payment_proof', 1)
            ->where('is_verified_payment_proof', 1)
            ->where('is_disqualified', 0)
            ->where('is_not_attend', 0)
            ->where('is_question_sended', 1)
            ->where('is_done_email_completed', 0)
            ->count();

        $statistics['completed_participation_process'] = $event->events_participants
            ->where('event_id', $id)
            ->where('is_approved_application', 1)
            ->where('is_verified_payment_proof', 1)
            ->where('is_verified_payment_proof', 1)
            ->where('is_disqualified', 0)
            ->where('is_not_attend', 0)
            ->where('is_question_sended', 1)
            ->where('is_done_email_completed', 1)
            ->count();

        $venues = Venue::all();

        $shortcourses = ShortCourse::all();

        $users = User::all();

        // $trainers = array();
        foreach ($event->events_trainers as $event_trainer) {
            $event_trainer->trainer->user = User::find($event_trainer->trainer->user_id);
        }
        // dd($event);
        //
        return view('short-course-management.event-management.show', compact('event', 'venues', 'shortcourses', 'users', 'statistics'));
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

        if ($request->is_base_fee_select_edit == 0) {
            $promo_code = $request->promo_code;
        } else {
            $promo_code = null;
        }

        $update = Fee::find($request->id)->update([
            'is_base_fee' => $request->is_base_fee_select_edit,
            'promo_code' => $promo_code,
            'promo_end_datetime' => null,
            'name' => $request->name_fee_edit,
            'event_id' => $id,
            'amount' => $request->amount,
            'updated_by' => Auth::user()->id,
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

        if ($request->is_base_fee_select_add == 0) {
            $promo_code = $request->promo_code_add;
        } else {
            $promo_code = null;
        }

        $create = Fee::create([
            'is_base_fee' => $request->is_base_fee_select_add,
            'promo_code' => $promo_code,
            'promo_end_datetime' => null,
            'name' => $request->name,
            'event_id' => $id,
            'amount' => $request->amount,
            'created_by' => Auth::user()->id,
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
        // //
        $validated = $request->validate([
            'trainer_ic_input' => 'required',
        ], [
            'trainer_ic_input.required' => 'Please insert trainer ic of the trainer',
        ]);
        $existTrainer = Trainer::where('ic', $request->trainer_ic_input)->first();

        $create = EventTrainer::create([
            'event_id' => $id,
            'trainer_id' => $existTrainer->id,
            'is_done_paid' => 0,
            'trainer_representative_id' => $existTrainer->id,
            'created_by' => Auth::user()->id,
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
            'created_by' => Auth::user()->id,
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
        $index = 0;
        foreach ($events as $event) {
            $events[$index]->created_at_diffForHumans = $events[$index]->created_at->diffForHumans();
            $index++;
        }
        return view('short-course-management.shortcourse.event.index', compact('events'));

        // return view('short-course-management.event-management.index');
    }

    public function getFile($file)
    {
        // $path = storage_path().'/'.'app'.'/'.'shortcourse'.'/'.'system'.'/'.$file;
        $path = asset('/' . 'storage' . '/' . 'app' . '/' . 'shortcourse' . '/' . 'system' . '/' . $file);

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
        return view('short-course-management.shortcourse.event.show', compact('event'));
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


            $datetime_start = new DateTime($events[$index]->datetime_start);
            $datetime_end = new DateTime($events[$index]->datetime_end);
            $events[$index]['datetime_start_toDayDateTimeString'] = date_format($datetime_start, 'g:ia \o\n l jS F Y');
            $events[$index]['datetime_end_toDayDateTimeString'] = date_format($datetime_end, 'g:ia \o\n l jS F Y');

            $index++;
        }
        return datatables()::of($events)
            ->addColumn('name-with-href', function ($events) {
                return '
                <a href="/shortcourse/' . $events->id . '" class="text-primary">' . $events->name . '</a>';
            })
            ->addColumn('dates', function ($events) {
                return 'Date Start: <br>' . $events->datetime_start_toDayDateTimeString . '<br><br> Date End: <br>' . $events->datetime_end_toDayDateTimeString;
            })
            ->rawColumns(['name-with-href', 'dates'])
            ->make(true);
    }
}
