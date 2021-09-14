<?php

namespace App\Http\Controllers\ShortCourseManagement\EventManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShortCourseManagement\Category;
use App\Models\ShortCourseManagement\SubCategory;
use App\Models\ShortCourseManagement\Event;
use App\Models\ShortCourseManagement\EventParticipant;
use App\Models\ShortCourseManagement\Venue;
use App\Models\ShortCourseManagement\ShortCourse;
use App\Models\ShortCourseManagement\Trainer;
use App\Models\ShortCourseManagement\ContactPerson;
use App\Models\ShortCourseManagement\EventContactPerson;
use App\Models\ShortCourseManagement\Fee;
use App\Models\ShortCourseManagement\EventTrainer;
use App\Models\ShortCourseManagement\EventShortCourse;
use App\Models\ShortCourseManagement\TopicShortCourse;
use App\Models\ShortCourseManagement\Topic;
use App\Models\ShortCourseManagement\EventStatusCategory;
use App\Models\ShortCourseManagement\VenueType;
use App\Models\ShortCourseManagement\EventFeedbackSet;
use App\Models\ShortCourseManagement\ShortCourseICDLModule;
use App\Models\ShortCourseManagement\ShortCourseICDLModuleEventParticipant;

use App\Exports\ApplicantByModuleExport;
use Maatwebsite\Excel\Facades\Excel;

use Barryvdh\DomPDF\Facade as PDF;

use App\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
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
        $events = Event::orderByDesc('id')->get()->load(['events_participants', 'venue', 'event_status_category', 'events_shortcourses.shortcourse']);
        $index = 0;
        foreach ($events as $event) {
            if (isset($event->events_participants)) {
                $totalValidParticipants = $event->events_participants
                    ->where('event_id', $event->id)
                    ->where('is_approved_application', 1)
                    ->where('is_verified_payment_proof', 1)
                    ->where('is_disqualified', 0)
                    ->count();
                $totalParticipantsNotApprovedYet = $event->events_participants
                    ->where('event_id', $event->id)
                    ->where('is_disqualified', 0)
                    ->where('is_verified_payment_proof', 0)
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

            $events[$index]['datetime_start_toDayDateTimeString'] = date_format(new DateTime($events[$index]->datetime_start), 'g:ia \o\n l jS F Y');
            $events[$index]['datetime_end_toDayDateTimeString'] = date_format(new DateTime($events[$index]->datetime_end), 'g:ia \o\n l jS F Y');
            $events[$index]['created_at_toDayDateTimeString'] = date_format(new DateTime($events[$index]->created_at), 'g:ia \o\n l jS F Y');
            $index++;
        }


        return datatables()::of($events)
            ->addColumn('dates', function ($events) {
                return 'Date Start:<br>' . $events->datetime_start_toDayDateTimeString . '<br><br> Date End:<br>' . $events->datetime_end_toDayDateTimeString;
            })
            ->addColumn('participant', function ($events) {
                return 'Total Valid: ' . $events->totalValidParticipants . '<br><br> Total Not Approved Yet: ' . $events->totalParticipantsNotApprovedYet . '<br><br> Total Reject: ' . $events->totalRejected;
            })
            ->addColumn('management_details', function ($events) {
                return 'Created By: ' . $events->created_by . '<br> Created At: ' . $events->created_at;
            })
            ->addColumn('action', function ($events) {
                return '
                <a href="/event/' . $events->id . '/events-participants/show" class="btn btn-sm btn-primary">Participants</a><br/><br/>
                <a href="/event/' . $events->id . '" class="btn btn-sm btn-primary">Settings</a>';
            })
            ->addColumn('document', function ($events) {
                if (isset($events->events_shortcourses[0])) {

                    if ($events->events_shortcourses[0]->shortcourse->is_icdl == 1) {
                        return '
                        <a href="/event/participant-list/' . $events->id . '" class="btn btn-sm btn-info">Attendance Sheet</a><br/><br/>
                        <a data-page="/event/report/' . $events->id . '" class="btn btn-sm btn-info" style="color:white;" onclick="Print(this)">Event Report</a><br/><br/>
                        <a href="/event/exportApplicantByModule/' . $events->id . '" class="btn btn-sm btn-info">Applicants By Module</a>';
                    }
                }
                return '
                <a href="/event/participant-list/' . $events->id . '" class="btn btn-sm btn-info">Attendance Sheet</a><br/><br/>
                <a data-page="/event/report/' . $events->id . '" class="btn btn-sm btn-info" style="color:white;" onclick="Print(this)">Event Report</a>';
            })
            ->rawColumns(['action', 'management_details', 'participant', 'dates', 'document'])
            ->make(true);
        // <a href="#" class="btn btn-sm btn-info">Event Report</a>
    }
    public function create()
    {
        //

        $venues = Venue::orderBy('name')->get()->load(['venue_type']);

        $shortcourses = ShortCourse::orderByDesc('id')->get()->load(['topics_shortcourses.topic']);

        $index = 0;
        foreach ($shortcourses as $shortcourse) {
            $topics = [];
            foreach ($shortcourse->topics_shortcourses as $topic_shortcourse) {
                array_push($topics, $topic_shortcourse->topic);
            }
            $shortcourses[$index]['topics'] = $topics;
            $index += 1;
        }

        $topics = Topic::all();

        $users = User::where('category', 'STF')->orWhere('category', 'EXT')->get();

        $venue_types = VenueType::all();

        $event_feedback_sets = EventFeedbackSet::all();

        return view('short-course-management.event-management.create', compact('venues', 'shortcourses', 'topics', 'users', 'venue_types', 'event_feedback_sets'));
    }
    public function storeNew(Request $request)
    {
        //
        // dd($request->shortcourse_topic[0]);
        // Validator::extend('check_array', function ($attribute, $value, $parameters, $validator) {
        //     return count($value) >= 1;
        // });

        // dd($request);

        $validated = $request->validate([
            'shortcourse_id' => 'required',
            'shortcourse_name' => 'required|min:3',
            'shortcourse_description' => 'required|min:3',
            'shortcourse_objective' => 'required|min:3',
            // 'shortcourse_topic'  => 'check_array',
            'datetime_start' => 'required',
            'datetime_end' => 'required',
            'venue_id' => 'required',
            'venue_type_id' => 'required',
            'venue_name' => 'required|min:3',
            'fee_name' => 'required|min:3',
            'fee_id' => 'required',
            'fee_amount' => 'required|numeric',
            'event_feedback_set_id' => 'required',
            'trainer_ic' => 'required',
            'trainer_fullname' => 'required|min:3',
            'trainer_phone' => 'required|min:10',
            'trainer_email' => 'required|email:rfc',

        ], [
            'shortcourse_id.required' => 'Please choose short course of the event',
            'shortcourse_name.required' => 'Please insert event name',
            'shortcourse_name.min' => 'The name should have at least 3 characters',
            'shortcourse_description.required' => 'Please insert event description',
            'shortcourse_description.min' => 'The description should have at least 3 characters',
            'shortcourse_objective.required' => 'Please insert event objective',
            'shortcourse_objective.min' => 'The objective should have at least 3 characters',
            // 'shortcourse_topic.check_array' => 'Please insert at least one topic',
            'datetime_start.required' => 'Please insert event datetime start',
            'datetime_end.required' => 'Please insert event datetime end',
            'venue_id.required' => 'Please choose event venue',
            'venue_type_id.required' => 'Please insert venue type',
            'venue_name.required' => 'Please insert venue name',
            'venue_name.min' => 'The name should have at least 3 characters',
            'fee_name.required' => 'Please insert fee name',
            'fee_name.min' => 'The name should have at least 3 characters',
            'fee_id.required' => 'Please insert fee id',
            'fee_amount.required' => 'Please insert fee amount',
            'fee_amount.numeric' => 'Please insert number only',
            'event_feedback_set_id.required' => 'Please choose event feedback set',
            'trainer_ic.required' => 'Please insert trainer IC',
            'trainer_fullname.required' => "Please insert trainer's fullname",
            'trainer_fullname.min' => "The trainer's fullname should have at least 3 characters",
            'trainer_phone.required' => "Please insert trainer's phone number",
            'trainer_phone.min' => "The trainer's phone number should have at least 10 numbers",
            'trainer_email.required' => "Please insert trainer's email",

        ]);

        if ($request->shortcourse_id == -1) {
            //TODO: Create new shortcourse
            $createShortCourse = ShortCourse::create([
                'name' => $request->shortcourse_name,
                'description' => $request->shortcourse_description,
                'objective' => $request->shortcourse_objective,
                'created_by' => Auth::user()->id,
            ]);
            if (isset($request->shortcourse_topic)) {
                foreach ($request->shortcourse_topic as $shortcourse_topic) {

                    $createTopicShortCourse = TopicShortCourse::create([
                        'topic_id' => $shortcourse_topic,
                        'shortcourse_id' => $createShortCourse->id,
                        'created_by' => Auth::user()->id,
                    ]);
                }
            }
        }
        // else {
        //     $updateShortCourse = ShortCourse::find($request->shortcourse_id)->update([
        //         'name' => $request->shortcourse_name,
        //         'shortcourse_description' => $request->shortcourse_description,
        //         'shortcourse_objective' => $request->shortcourse_objective,
        //         'updated_by' => Auth::user()->id,
        //     ]);

        //     if (isset($request->shortcourse_topic)) {
        //         foreach ($request->shortcourse_topic as $shortcourse_topic) {
        //             $exist = TopicShortCourse::where([
        //                 ['shortcourse_id', '=', $request->shortcourse_id],
        //                 ['topic_id', '=', $shortcourse_topic],
        //             ])->get();

        //             if (!$exist) {
        //                 $createTopicShortCourse = TopicShortCourse::create([
        //                     'topic_id' => $shortcourse_topic,
        //                     'shortcourse_id' => $request->shortcourse_id,
        //                     'created_by' => Auth::user()->id,
        //                 ]);
        //             }
        //         }
        //     }
        // }





        if ($request->venue_id == -1) {
            $createVenue = Venue::create([
                'name' => $request->venue_name,
                'venue_type_id' => $request->venue_type_id,
                'description' => $request->venue_description,
                'created_by' => Auth::user()->id,
            ]);
        } else {
            // TODO: Update Venue Name
            // $updateVenue = Venue::find($request->venue_id)->update([
            //     'name' => $request->venue_name,
            //     'updated_by' => Auth::user()->id,
            // ]);
        }

        $createEvent = Event::create([
            'name' => $request->shortcourse_name,
            'description' => $request->shortcourse_description,
            'objective' => $request->shortcourse_objective,
            'event_feedback_set_id' => $request->event_feedback_set_id,
            'datetime_start' => $request->datetime_start,
            'datetime_end' => $request->datetime_end,
            'registration_due_date' => $request->datetime_start,
            'venue_id' => $request->venue_id == -1 ? $createVenue->id : $request->venue_id,
            'venue_description' => $request->venue_description,
            // 'thumbnail_path' => 'storage/shortcourse/poster/default/intec_poster.jpg',
            'created_by' => Auth::user()->id,
        ]);

        $createEventShortCourse = EventShortCourse::create([
            'event_id' => $createEvent->id,
            'shortcourse_id' => $request->shortcourse_id == -1 ? $createShortCourse->id : $request->shortcourse_id,
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
            $existUser = User::where('id', $request->trainer_user_id_hidden)->first();
            if (!$existUser) {
                // TODO: Create User
                $existUser = User::create([
                    'id' => $request->trainer_ic,
                    'name' => $request->trainer_fullname,
                    'username' => $request->trainer_ic,
                    'email' => $request->trainer_email,
                    'active' => 'Y',
                    'category' => 'EXT',
                    'password' => Hash::make($request->trainer_ic),
                ]);
            }
            if ($existUser) {
                $existTrainer = Trainer::create([
                    'user_id' => $existUser->id,
                    'ic' => $request->trainer_ic,
                    'phone' => $request->trainer_phone,
                    'email' => $request->trainer_email,
                    'created_by' => Auth::user()->id,
                ]);
            }
        }

        $create = EventTrainer::create([
            'event_id' => $createEvent->id,
            'trainer_id' => $existTrainer->id,
            'is_done_paid' => 0,
            'trainer_representative_id' => $existTrainer->id,
            'phone' => $request->trainer_phone,
            'created_by' => Auth::user()->id,
            'is_active' => 1,
        ]);

        // Redirect to show
        $event = Event::find($createEvent->id)->load([
            'events_participants',
            'venue',
            'events_shortcourses.shortcourse.shortcourse_icdl_modules',
            'events_trainers.trainer',
            'fees'
        ]);

        if ($event->events_shortcourses[0]->shortcourse->is_icdl == 1) {
            $index_module = 0;

            foreach ($event->events_shortcourses[0]->shortcourse->shortcourse_icdl_modules as $shortcourse_icdl_module) {
                $event->events_shortcourses[0]->shortcourse->shortcourse_icdl_modules[$index_module]->totalApplication = ShortCourseICDLModuleEventParticipant::where('shortcourse_icdl_module_id', $shortcourse_icdl_module->id)->get()->count();
                $index_module++;
            }
        }


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

    public function show($id)
    {

        $event = Event::find($id)->load([
            'events_participants',
            'venue',
            'events_shortcourses.shortcourse.shortcourse_icdl_modules',
            'events_trainers.trainer',
            'fees',
            'event_status_category',
            'events_contact_persons.contact_person',
            'event_feedback_set'
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
            ->whereNull('is_verified_payment_proof')
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

        $event_feedback_sets = EventFeedbackSet::all();

        $users = User::where('category', 'STF')->orWhere('category', 'EXT')->get();
        $eventStatusCategories = EventStatusCategory::all();

        // $trainers = array();
        foreach ($event->events_trainers as $event_trainer) {
            $event_trainer->trainer->user = User::find($event_trainer->trainer->user_id);
        }


        foreach ($event->events_contact_persons as $event_contact_person) {
            $event_contact_person->contact_person->user = User::find($event_contact_person->contact_person->user_id);
        }

        if ($event->events_shortcourses[0]->shortcourse->is_icdl == 1) {
            $index_module = 0;

            foreach ($event->events_shortcourses[0]->shortcourse->shortcourse_icdl_modules as $shortcourse_icdl_module) {
                $event->events_shortcourses[0]->shortcourse->shortcourse_icdl_modules[$index_module]->totalApplication = ShortCourseICDLModuleEventParticipant::where('shortcourse_icdl_module_id', $shortcourse_icdl_module->id)->get()->count();
                $index_module++;
            }
        }
        // dd($event->fees);
        //
        return view('short-course-management.event-management.show', compact('event', 'venues', 'shortcourses', 'users', 'statistics', 'eventStatusCategories', 'event_feedback_sets'));
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
            'event_feedback_set' => 'required',
            'max_participant' => 'required',
        ], [
            'name.required' => 'Please insert event name',
            'name.max' => 'Name exceed maximum length',
            'datetime_start.required' => 'Please insert event datetime start',
            'datetime_end.required' => 'Please insert event datetime end',
            'event_feedback_set.required' => 'Please insert set of feedback to be used for the event',
            'max_participant.required' => 'Please insert total seat of the event',
        ]);

        $update = Event::find($id)->update([
            'name' => $request->name,
            'datetime_start' => $request->datetime_start,
            'datetime_end' => $request->datetime_end,
            'venue_id' => $request->venue,
            'venue_description' => $request->venue_description,
            'event_feedback_set_id' => $request->event_feedback_set,
            'max_participant' => $request->max_participant,
        ]);

        return Redirect()->back()->with('successUpdateGeneral', 'Basic Information Updated Successfully');
    }
    public function updateFee(Request $request, $id)
    {
        // //
        $validated = $request->validate([
            'name_fee_edit' => 'required|max:255',
            'amount_edit' => 'required',
            'is_base_fee_select_edit_input' => 'required',
        ], [
            'name_fee_edit.required' => 'Please insert fee name',
            'name_fee_edit.max' => 'Name exceed maximum length',
            'amount_edit.required' => 'Please insert fee amount',
            'is_base_fee_select_edit_input.required' => 'Please insert fee type',
        ]);


        if ($request->is_base_fee_select_edit_input == 0) {
            $promo_code = $request->promo_code;
        } else {
            $promo_code = null;
        }

        $update = Fee::find($request->fee_id)->update([
            'is_base_fee' => $request->is_base_fee_select_edit_input,
            'promo_code' => $promo_code,
            'promo_end_datetime' => null,
            'name' => $request->name_fee_edit,
            'event_id' => $id,
            'amount' => $request->amount_edit,
            'updated_by' => Auth::user()->id,
            'is_active' => 1,
        ]);

        return Redirect()->back()->with('successUpdateGeneral', 'Fee Updated Successfully');
    }

    public function storeFee(Request $request, $id)
    {
        // dd($request);
        // //
        $validated = $request->validate([
            'name' => 'required|max:255',
            'amount_add' => 'required',
            'is_base_fee_select_add_input' => 'required',
            'promo_code' => 'required',
        ], [
            'name.required' => 'Please insert fee name',
            'name.max' => 'Name exceed maximum length',
            'amount_add.required' => 'Please insert fee amount',
            'is_base_fee_select_add_input.required' => 'Please insert fee type',
            'promo_code.required' => 'Please insert promo code for the fee',
        ]);

        if ($request->is_base_fee_select_add_input == 0) {
            $promo_code = $request->promo_code;
        } else {
            $promo_code = null;
        }

        $create = Fee::create([
            'is_base_fee' => $request->is_base_fee_select_add_input,
            'promo_code' => $promo_code,
            'promo_end_datetime' => null,
            'name' => $request->name,
            'event_id' => $id,
            'amount' => $request->amount_add,
            'created_by' => Auth::user()->id,
            'is_active' => 1,
        ]);

        return Redirect()->back()->with('successUpdateGeneral', 'New Fee Created Successfully');
    }



    public function deleteFee($fee_id)
    {

        $exist = Fee::find($fee_id);
        $exist->updated_by = Auth::user()->id;
        $exist->deleted_by = Auth::user()->id;
        $exist->save();
        $exist->delete();

        return Redirect()->back()->with('successUpdateGeneral', 'A Fee Deleted Successfully');
    }

    public function detachedTrainer($EventTrainer_id)
    {

        $exist = EventTrainer::find($EventTrainer_id);
        $exist->updated_by = Auth::user()->id;
        $exist->deleted_by = Auth::user()->id;
        $exist->save();
        $exist->delete();

        return Redirect()->back()->with('successUpdateGeneral', 'A Trainer Removed Successfully');
    }

    public function detachedContactPerson($event_contact_person_id)
    {

        $exist = EventContactPerson::find($event_contact_person_id);
        $exist->updated_by = Auth::user()->id;
        $exist->deleted_by = Auth::user()->id;
        $exist->save();
        $exist->delete();

        return Redirect()->back()->with('successUpdateGeneral', 'A Contact Person Removed Successfully');
    }



    public function detachedShortCourse($EventShortCourse_id)
    {

        $exist = EventShortCourse::find($EventShortCourse_id);
        $exist->updated_by = Auth::user()->id;
        $exist->deleted_by = Auth::user()->id;
        $exist->save();
        $exist->delete();

        return Redirect()->back()->with('messageEventBasicDetails', 'A Short Course Removed Successfully');
    }

    public function storeTrainer(Request $request, $event_id)
    {
        // //
        // dd($request);
        $validated = $request->validate([
            'trainer_ic_input' => 'required',
            'trainer_user_id' => 'required',
            'trainer_fullname' => 'required',
            'trainer_phone' => 'required',
            'trainer_email' => 'required',
        ]);

        $existTrainer = Trainer::where('ic', '=', $request->trainer_ic_input)->first();

        if (!$existTrainer) {
            $existUser = User::where('id', $request->trainer_user_id)->first();
            if (!$existUser) {
                // TODO: Create User
                $existUser = User::create([
                    'id' => $request->trainer_ic_input,
                    'name' => $request->trainer_fullname,
                    'username' => $request->trainer_ic_input,
                    'email' => $request->trainer_email,
                    'active' => 'Y',
                    'category' => 'EXT',
                    'password' => Hash::make($request->trainer_ic_input),
                ]);
            }
            if ($existUser) {
                $existTrainer = Trainer::create([
                    'user_id' => $existUser->id,
                    'ic' => $request->trainer_ic_input,
                    'phone' => $request->trainer_phone,
                    'email' => $request->trainer_email,
                    'created_by' => Auth::user()->id,
                ]);
            }
        }

        $createEventTrainer = EventTrainer::create([
            'event_id' => $event_id,
            'trainer_id' => $existTrainer->id,
            'is_done_paid' => 0,
            'trainer_representative_id' => $existTrainer->id,
            'created_by' => Auth::user()->id,
            'is_active' => 1,
        ]);

        // $existTrainer = Trainer::where('ic', $request->trainer_ic_input)->first();

        // $create = EventTrainer::create([
        //     'event_id' => $event_id,
        //     'trainer_id' => $existTrainer->id,
        //     'is_done_paid' => 0,
        //     'trainer_representative_id' => $existTrainer->id,
        //     'phone' => $request->trainer_phone,
        //     'created_by' => Auth::user()->id,
        //     'is_active' => 1,
        // ]);


        return Redirect()->back()->with('successUpdateGeneral', 'A Trainer Updated Successfully');
    }

    public function storeContactPerson(Request $request, $event_id)
    {
        // //
        // dd($request);
        $validated = $request->validate([
            'contact_person_ic_input' => 'required',
            'contact_person_user_id' => 'required',
            'contact_person_fullname' => 'required',
            'contact_person_phone' => 'required',
            'contact_person_email' => 'required',
        ]);

        $existContactPerson = ContactPerson::where('ic', '=', $request->contact_person_ic_input)->first();

        // dd($existContactPerson);
        if (!$existContactPerson) {
            $existUser = User::where('id', $request->contact_person_user_id)->first();
            if (!$existUser) {
                // TODO: Create User
                $existUser = User::create([
                    'id' => $request->contact_person_ic_input,
                    'name' => $request->contact_person_fullname,
                    'username' => $request->contact_person_ic_input,
                    'email' => $request->contact_person_email,
                    'active' => 'Y',
                    'category' => 'EXT',
                    'password' => Hash::make($request->contact_person_ic_input),
                ]);
            }
            if ($existUser) {
                $existContactPerson = ContactPerson::create([
                    'user_id' => $existUser->id,
                    'ic' => $request->contact_person_ic_input,
                    'phone' => $request->contact_person_phone,
                    'email' => $request->contact_person_email,
                    'created_by' => Auth::user()->id,
                ]);
            }
        }

        $createEventContactPerson = EventContactPerson::create([
            'event_id' => $event_id,
            'contact_person_id' => $existContactPerson->id,
            'created_by' => Auth::user()->id,
            'is_active' => 1,
        ]);


        return Redirect()->back()->with('successUpdateGeneral', 'A Contact Person Updated Successfully');
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

        return Redirect()->back()->with('successUpdateGeneral', 'A Short Course Updated Successfully');
    }
    public function destroy($id)
    {
        //
    }

    //Public View

    public function indexPublicView()
    {
        $events = Event::where([['event_status_category_id', '=', 2], ['datetime_start', '>=', Carbon::today()->toDateString()]])->orderByDesc('created_at')->get()->load(['events_participants', 'venue', 'fees']);
        $index = 0;
        foreach ($events as $event) {
            $events[$index]->created_at_diffForHumans = $events[$index]->created_at->diffForHumans();
            $index++;
        }
        $categories = Category::all();
        $subcategories = SubCategory::all();
        $topics = Topic::all();
        return view('short-course-management.shortcourse.event.index', compact('events', 'categories', 'subcategories', 'topics'));

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
            'events_shortcourses.shortcourse.shortcourse_icdl_modules',
            'events_trainers.trainer',
            'fees',
            'events_contact_persons.contact_person'
        ]);

        $index = 0;
        foreach ($event->events_contact_persons as $event_contact_person) {
            $user = User::find($event_contact_person->contact_person->user_id);
            $event->events_contact_persons[$index]->contact_person['user'] = $user;
            $index += 1;
        }
        $currentApplicants = $event->events_participants
            ->where('is_approved_application', 1)
            ->count();

        $event->total_seat_available = $event->max_participant - $currentApplicants;


        //
        return view('short-course-management.shortcourse.event.show', compact('event'));
    }

    public function dataPublicView(Request $request)
    {
        // dd($request->category_id);
        // $events = Event::where([['event_status_category_id', '=', 2], ['datetime_start', '>=', Carbon::today()->toDateString()]])->orderBy('datetime_start')->get()->load(['events_participants', 'venue']);
        if ($request->category_id == -1 && $request->subcategory_id == -1 && $request->topic_id == -1) {
            $events = Event::where([['event_status_category_id', '=', 2]])->distinct()->orderBy('datetime_start')->get()->load(['events_participants', 'venue', 'events_shortcourses.shortcourse.topics_shortcourses.topic']);
        } else if ($request->category_id != -1 && $request->subcategory_id == -1 && $request->topic_id == -1) {
            // $category =Category::find($request->category_id)->load(['subcategories.topics.topics_shortcourses.shortcourse.events_shortcourses.event.events_participants','subcategories.topics.topics_shortcourses.shortcourse.events_shortcourses.event.venue']);
            // $events = Event::where([['event_status_category_id', '=', 2]])
            //         ->whereHas('events_shortcourses', function ($query) use ($category_id) {
            //             $query->whereHas('shortcourse', function ($query) use ($category_id) {
            //                 $query->whereHas('topics_shortcourses', function ($query) use ($category_id) {
            //                     $query->whereHas('topics', function ($query) use ($category_id) {
            //                         $query->whereHas('subcategories', function ($query) use ($category_id) {
            //                             $query->where('category_id', $category_id);
            //                         });
            //                     });
            //                 });
            //             });
            //     })->orderBy('datetime_start')->get()->load(['events_participants', 'venue']);
            $category_id = $request->category_id;
            $events = Event::where([['event_status_category_id', '=', 2]])
                ->join('scm_event_shortcourse', 'scm_event.id', '=', 'scm_event_shortcourse.event_id')
                ->join('scm_shortcourse', 'scm_event_shortcourse.shortcourse_id', '=', 'scm_shortcourse.id')
                ->join('scm_topic_shortcourse', 'scm_shortcourse.id', '=', 'scm_topic_shortcourse.shortcourse_id')
                ->join('scm_topic', 'scm_topic_shortcourse.topic_id', '=', 'scm_topic.id')
                ->join('scm_subcategory', 'scm_topic.subcategory_id', '=', 'scm_subcategory.id')
                ->where('scm_subcategory.category_id', '=', $category_id)
                ->where('scm_event.deleted_at', '=', null)
                ->where('scm_event_shortcourse.deleted_at', '=', null)
                ->where('scm_shortcourse.deleted_at', '=', null)
                ->where('scm_topic_shortcourse.deleted_at', '=', null)
                ->where('scm_topic.deleted_at', '=', null)
                ->where('scm_subcategory.deleted_at', '=', null)->distinct()->orderBy('datetime_start')
                ->get(['scm_event.*'])->load(['events_participants', 'venue', 'events_shortcourses.shortcourse.topics_shortcourses.topic']);
        } else if ($request->category_id != -1 && $request->subcategory_id != -1 && $request->topic_id == -1) {
            $subcategory_id = $request->subcategory_id;
            $events = Event::where([['event_status_category_id', '=', 2]])
                ->join('scm_event_shortcourse', 'scm_event.id', '=', 'scm_event_shortcourse.event_id')
                ->join('scm_shortcourse', 'scm_event_shortcourse.shortcourse_id', '=', 'scm_shortcourse.id')
                ->join('scm_topic_shortcourse', 'scm_shortcourse.id', '=', 'scm_topic_shortcourse.shortcourse_id')
                ->join('scm_topic', 'scm_topic_shortcourse.topic_id', '=', 'scm_topic.id')
                ->where('scm_topic.subcategory_id', '=', $subcategory_id)
                ->where('scm_event.deleted_at', '=', null)
                ->where('scm_event_shortcourse.deleted_at', '=', null)
                ->where('scm_shortcourse.deleted_at', '=', null)
                ->where('scm_topic_shortcourse.deleted_at', '=', null)
                ->where('scm_topic.deleted_at', '=', null)->distinct()->orderBy('datetime_start')
                ->get(['scm_event.*'])->load(['events_participants', 'venue', 'events_shortcourses.shortcourse.topics_shortcourses.topic']);
        } else if ($request->category_id != -1 && $request->subcategory_id != -1 && $request->topic_id != -1) {
            $topic_id = $request->topic_id;
            $events = Event::where([['event_status_category_id', '=', 2]])
                ->join('scm_event_shortcourse', 'scm_event.id', '=', 'scm_event_shortcourse.event_id')
                ->join('scm_shortcourse', 'scm_event_shortcourse.shortcourse_id', '=', 'scm_shortcourse.id')
                ->join('scm_topic_shortcourse', 'scm_shortcourse.id', '=', 'scm_topic_shortcourse.shortcourse_id')
                ->where('scm_topic_shortcourse.topic_id', '=', $topic_id)
                ->where('scm_event.deleted_at', '=', null)
                ->where('scm_event_shortcourse.deleted_at', '=', null)
                ->where('scm_shortcourse.deleted_at', '=', null)
                ->where('scm_topic_shortcourse.deleted_at', '=', null)->distinct()->orderBy('datetime_start')
                ->get(['scm_event.*'])->load(['events_participants', 'venue', 'events_shortcourses.shortcourse.topics_shortcourses.topic']);
        }
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
            $topic_list_string = '';
            $topicIndex = 1;
            if (isset($event->events_shortcourses)) {
                foreach ($event->events_shortcourses as $event_shortcourse) {
                    if (isset($event_shortcourse->shortcourse->topics_shortcourses)) {
                        foreach ($event_shortcourse->shortcourse->topics_shortcourses as $topic_shortcourse) {
                            $topic_list_string .= $topicIndex . ') ' . $topic_shortcourse->topic->name . '<br>';
                            $topicIndex += 1;
                        }
                    }
                }
            }
            $events[$index]->totalValidParticipants = $totalValidParticipants;
            $events[$index]->totalParticipantsNotApprovedYet = $totalParticipantsNotApprovedYet;
            $events[$index]->totalRejected = $totalRejected;
            $events[$index]->topic_list_string = $topic_list_string;


            $datetime_start = new DateTime($events[$index]->datetime_start);
            $datetime_end = new DateTime($events[$index]->datetime_end);
            $events[$index]['datetime_start_toDayDateTimeString'] = date_format($datetime_start, 'g:ia \o\n l jS F Y');
            $events[$index]['datetime_end_toDayDateTimeString'] = date_format($datetime_end, 'g:ia \o\n l jS F Y');

            $index++;
        }
        return datatables()::of($events)
            ->addColumn('name-with-href', function ($events) {
                $htmlString = '<a href="/shortcourse/' . $events->id . '" class="text-primary">' . $events->name . '</a>';

                return $htmlString;
            })
            ->addColumn('dates', function ($events) {
                return 'Date Start: <br>' . $events->datetime_start_toDayDateTimeString . '<br><br> Date End: <br>' . $events->datetime_end_toDayDateTimeString;
            })
            ->rawColumns(['name-with-href', 'dates', 'topic_list_string'])
            ->make(true);
    }

    public function updatePoster(Request $request)
    {
        $date = Carbon::today()->toDateString();
        $year = substr($date, 0, 4);
        $month = substr($date, 5, 2);
        $day = substr($date, 8, 2);

        $validated = $request->validate([
            'poster_input' => 'required|mimes:jpg,jpeg,png',

        ], [
            'poster_input.required' => 'Poster is required',

        ]);
        $poster = $request->file('poster_input');


        $name_gen = hexdec(uniqid());
        $img_ext = strtolower($poster->getClientOriginalExtension());

        $img_name = $year . $month . $day . '_id' . ($request->event_id) . '_' . $name_gen . '.' . $img_ext;

        /* utk file upload, create folder shortcourse under storage/app.
        so semua file upload berkaitan sistem shortcourse akan ada dalam storage/app/shortcourse.
        kat dalam folder tu terpulang lah mcm mana nak susun.ikut kesesuaian data.
        normally kalau data mcm shortcourse ni sy buat subfolder tahun/courseid */


        $up_location = 'storage/shortcourse/poster/' . $year . '/';
        $last_img = $up_location . $img_name;

        $poster->move($up_location, $img_name);

        Event::find($request->event_id)->update([
            'thumbnail_path' => $last_img,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now()
        ]);

        return Redirect()->back()->with('success', 'Poster Updated Successfully');
    }

    public function updateSpecificEditor(Request $request)
    {
        // dd($request);
        Event::find($request->event_id)->update([
            'description' => $request->editor_description,
            'target_audience' => $request->editor_target_audience,
            'outline' => $request->editor_outline,
            'tentative' => $request->editor_tentative,
            'objective' => $request->editor_objective,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now()
        ]);

        return Redirect()->back()->with('success', 'Event Objective, Outline and Tentative  Updated Successfully');
    }

    public function updateEventStatus($event_id, $event_status_category_id)
    {
        Event::find($event_id)->update([
            'event_status_category_id' => $event_status_category_id,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now()
        ]);

        // $update=Event::find($event_id)->load(['event_status_category']);

        return Redirect()->back()->with('success', 'Event Status Updated Successfully');
    }

    public function delete($id)
    {

        $exists = Event::find($id);
        $exists->updated_by = Auth::user()->id;
        $exists->deleted_by = Auth::user()->id;
        $exists->save();
        $exists->delete();

        $exists = EventShortCourse::where('event_id', $id)->get();
        $index = 0;
        foreach ($exists as $exist) {
            $exists[$index]->updated_by = Auth::user()->id;
            $exists[$index]->deleted_by = Auth::user()->id;
            $exists[$index]->save();
            $exists[$index]->delete();
            $index++;
        }

        $exists = EventTrainer::where('event_id', $id)->get();
        $index = 0;
        foreach ($exists as $exist) {
            $exists[$index]->updated_by = Auth::user()->id;
            $exists[$index]->deleted_by = Auth::user()->id;
            $exists[$index]->save();
            $exists[$index]->delete();
            $index++;
        }

        $exists = EventContactPerson::where('event_id', $id)->get();
        $index = 0;
        foreach ($exists as $exist) {
            $exists[$index]->updated_by = Auth::user()->id;
            $exists[$index]->deleted_by = Auth::user()->id;
            $exists[$index]->save();
            $exists[$index]->delete();
            $index++;
        }

        $exists = Fee::where('event_id', $id)->get();
        $index = 0;
        foreach ($exists as $exist) {
            $exists[$index]->updated_by = Auth::user()->id;
            $exists[$index]->deleted_by = Auth::user()->id;
            $exists[$index]->save();
            $exists[$index]->delete();
            $index++;
        }

        return $exists;
    }
    public function participantList($id)
    {
        // dd('succeed');
        $events_participants = EventParticipant::where('event_id', $id)->where('is_approved_application', 1)
            ->where('is_verified_payment_proof', 1)
            ->where('is_verified_payment_proof', 1)
            ->where('is_disqualified', 0)->get()->load(['participant']);

        $event = Event::find($id)->load(['venue']);
        $curr_date = Carbon::now()->format('jS F Y');

        $pdf = PDF::loadView('short-course-management.pdf.participant_list', compact('curr_date', 'events_participants', 'event'));
        return $pdf->stream($id . '_participant_list.pdf');
    }
    public function eventReport($id)
    {
        $event = Event::find($id)->load(['venue', 'event_feedback_set.sections.questions.events_participants_questions_answers.event_participant']);

        $statistics = array();
        $comments = array();
        $total_rating_question = 0;
        $total_participants_answered_feedback = 0;
        $total_rate_1 = 0;
        $total_rate_2 = 0;
        $total_rate_3 = 0;
        $total_rate_4 = 0;
        $total_rate_5 = 0;
        $index = 0;
        foreach ($event->event_feedback_set->sections as $section) {
            foreach ($section->questions as $question) {
                $events_participants = EventParticipant::where('event_id', $id)->get();
                if ($question->question_type == 'RATE') {
                    $question_answers = $question->events_participants_questions_answers->where('event_participant.event_id', $id) ?
                        $question->events_participants_questions_answers->where('event_participant.event_id', $id)->all() : null;

                    $statistics[$index]['question'] = $question->question;

                    $statistics[$index]['rate_1'] = $question_answers ? count(array_filter($question_answers, function ($question_answer) {
                        return $question_answer->rate === 1;
                    })) : 0;
                    $statistics[$index]['rate_2'] = $question_answers ?  count(array_filter($question_answers, function ($question_answer) {
                        return $question_answer->rate === 2;
                    })) : 0;
                    $statistics[$index]['rate_3'] = $question_answers ?  count(array_filter($question_answers, function ($question_answer) {
                        return $question_answer->rate === 3;
                    })) : 0;
                    $statistics[$index]['rate_4'] = $question_answers ?  count(array_filter($question_answers, function ($question_answer) {
                        return $question_answer->rate === 4;
                    })) : 0;
                    $statistics[$index]['rate_5'] = $question_answers ?  count(array_filter($question_answers, function ($question_answer) {
                        return $question_answer->rate === 5;
                    })) : 0;


                    $total_rating_question += 1;

                    $total_participants_answered_feedback = count($question_answers);


                    $total_rate_1 += ($statistics[$index]['rate_1'] * 1);
                    $total_rate_2 += ($statistics[$index]['rate_2'] * 2);
                    $total_rate_3 += ($statistics[$index]['rate_3'] * 3);
                    $total_rate_4 += ($statistics[$index]['rate_4'] * 4);
                    $total_rate_5 += ($statistics[$index]['rate_5'] * 5);
                    $index += 1;
                } else {
                    $comments[$index]['question'] = $question->question;

                    $question_answers = $question->events_participants_questions_answers->where('event_participant.event_id', $id) ?
                        $question->events_participants_questions_answers->where('event_participant.event_id', $id)->all() : null;
                    // dd($question_answers);
                    $comments[$index]['answers'] = [];
                    foreach ($question_answers as $question_answer) {
                        $temp2 = $question_answers ? $question_answer->description : null;
                        if ($temp2 != null) {
                            array_push($comments[$index]['answers'], $temp2);
                        }
                    }

                    $index += 1;
                }
            }
        }
        $fullmark_mark_by_rate = $total_rating_question * 5 * $total_participants_answered_feedback;
        $received_mark_by_rate = $total_rate_1 + $total_rate_2 + $total_rate_3 + $total_rate_4 + $total_rate_5;
        if ($fullmark_mark_by_rate != 0) {
            $statistics_summary['mark_by_rate'] = round(($received_mark_by_rate / $fullmark_mark_by_rate) * 100, 2);
        } else {
            $statistics_summary['mark_by_rate'] = 0;
        }
        $chart = [
            ['Rate 1', $total_rate_1, '#F52100'],
            ['Rate 2', $total_rate_2, '#EC08FF'],
            ['Rate 3', $total_rate_3, '#1005E8'],
            ['Rate 4', $total_rate_4, '#08CCFF'],
            ['Rate 5', $total_rate_5, '#00D443']
        ];

        // $pdf = PDF::loadView('short-course-management.pdf.event_report', compact('event', 'chart', 'statistics', 'comments', 'statistics_summary'));

        // return $pdf->stream($id . '_event_report.pdf');

        return view('short-course-management.pdf.event_report', compact('event', 'chart', 'statistics', 'comments', 'statistics_summary'));
    }

    public function exportApplicantByModule($event_id)
    {
        $event= Event::find($event_id)->load(['events_participants', 'venue', 'event_status_category', 'events_shortcourses.shortcourse']);
        $data=$event;
        return Excel::download(new ApplicantByModuleExport($data), 'ApplicantByModuleExport.xlsx');
    }
    // Generate pdf in laravel, then pass to frontend;
}
