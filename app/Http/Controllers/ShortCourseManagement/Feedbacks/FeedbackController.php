<?php

namespace App\Http\Controllers\ShortCourseManagement\Feedbacks;

use App\Models\ShortCourseManagement\Question;
use App\Models\ShortCourseManagement\Section;
use App\Models\ShortCourseManagement\EventParticipant;
use App\Models\ShortCourseManagement\EventParticipantQuestionAnswer;
use App\Models\ShortCourseManagement\EventFeedbackSet;
use App\Models\ShortCourseManagement\Participant;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;
use Auth;

class FeedbackController extends Controller
{
    public function form()
    {
        $sections = Section::all()->load(['questions']);
        return view('short-course-management.feedback.index', compact('sections'));
    }
    public function viewForm($id)
    {
        $event_feedback_set = EventFeedbackSet::find($id)->load(['sections.questions']);
        return view('short-course-management.feedback.index', compact('event_feedback_set'));
    }

    public function index()
    {
        $FeedbackSet = EventFeedbackSet::all()->load(['events']);
        return view('short-course-management.catalogues.feedback-set-catalogue.index', compact('FeedbackSet'));
    }

    public function showDetails($id)
    {
        $event_feedback_set = EventFeedbackSet::find($id)->load([
            'events',
        ]);


        if (isset($event_feedback_set->events)) {
            $totalEvents = $event_feedback_set->events->count();
        } else {
            $totalEvents = 0;
        }
        $event_feedback_set->totalEvents = $totalEvents;

        return view('short-course-management.catalogues.feedback-set-catalogue.show', compact('event_feedback_set'));
    }

    public function create()
    {
    }
    public function store(Request $request)
    {
    }
    public function show($event_participant_id, $sha1_ic)
    {
        $participant_id = Participant::where('sha1_ic', $sha1_ic)->first();
        if (isset($participant_id)) {
            $event_participant_question_id = EventParticipantQuestionAnswer::where('event_participant_id', $event_participant_id)->first();
            if (!$event_participant_question_id) {

                $event_participant = EventParticipant::find($event_participant_id)->load(['Participant', 'Event']);

                $event_feedback_set = EventFeedbackSet::find($event_participant->event->event_feedback_set_id)->load(['sections.questions']);
                return view('short-course-management.feedback.index', compact('event_feedback_set', 'event_participant'));
            } else {
                return redirect('/feedback/appreciation');
            }
        }
    }

    public function submit(Request $request)
    {
        $sections = Section::all()->load(['questions']);
        $rules = array();
        foreach ($sections as $section) {
            foreach ($section->questions as $question) {
                $rules["q" . strtoupper(substr($question->question_type, 0, 4)) . strval($question->id)] = 'required';
            }
        }

        $validated = $request->validate($rules);
        $event_participant_question_id = EventParticipantQuestionAnswer::where('event_participant_id', $request->event_participant_id)->first();
        $data = $request->all();

        if (!$event_participant_question_id) {
            foreach ($request->all() as $key => $value) {
                $input_type = substr($key, 0, 1);
                if (strcmp($input_type, 'q') == 0) {
                    $input_type2 = substr($key, 1, 4);
                    $question_id = substr($key, 5);
                    if (strcmp($input_type2, 'RATE') == 0) {
                        EventParticipantQuestionAnswer::create([
                            'question_id' => $question_id,
                            'event_participant_id' => $request->event_participant_id,
                            'rate' => $value,
                            'description' => null,
                            'created_by' => 'public_user',
                        ]);
                    } else if (strcmp($input_type2, 'TEXT') == 0) {
                        EventParticipantQuestionAnswer::create([
                            'question_id' => $question_id,
                            'event_participant_id' => $request->event_participant_id,
                            'rate' => null,
                            'description' => $value,
                            'created_by' => 'public_user',
                        ]);
                    }
                }
            }
            $eventParticipant=EventParticipant::find($request->event_participant_id)->load(['event.venue','participant']);
            $message =  [
                'opening' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . ($eventParticipant->participant->name),
                'introduction' => 'Tahniah! Anda telah <b>BERJAYA MEMBUAT MAKLUM BALAS</b> bagi program, ',
                'detail' => 'Program: ' . ($eventParticipant->event->name)
                    . '<br/>Tarikh: ' . ($eventParticipant->event->datetime_start) . ' sehingga ' . ($eventParticipant->event->datetime_end)
                    . '<br/>Tempat: ' . ($eventParticipant->event->venue->name),
                'conclusion' => 'Kami amat menghargai segala usaha anda. Semoga anda terus berjaya. Terima kasih.',
                'sha1_ic' => ($eventParticipant->participant->sha1_ic),
                'event_participant_id' => ($eventParticipant->id),
            ];

            Mail::send('short-course-management.email.email-payment-verified', $message, function ($message) use ($eventParticipant) {
                $message->subject('Pengesahan Maklum Balas (Berjaya Diterima)');
                $message->from(Auth::user()->email);
                $message->to($eventParticipant->participant->email);
            });

            $update = EventParticipant::find($eventParticipant->id)->update([
                'is_question_sended' => 1,
                'question_sended_datetime' => Carbon::now(),
                'is_done_email_completed' => 1,
                'done_email_completed_datetime'=>Carbon::now(),
            ]);
        }
        return redirect('/feedback/appreciation');
    }
    public function appreciation()
    {
        return view('short-course-management.feedback.appreciation');
    }

    public function delete(Request $request, $id)
    {

        $exist = EventFeedbackSet::find($id);
        if (Auth::user()->id) {
            $exist->updated_by = Auth::user()->id;
            $exist->deleted_by = Auth::user()->id;
        } else {
            $exist->updated_by = "public_user";
            $exist->deleted_by = "public_user";
        }
        $exist->save();
        $exist->delete();
        return $exist;
    }

    public function dataEventFeedbackSet()
    {
        $event_feedback_sets = EventFeedbackSet::orderByDesc('id')->get()->load(['events']);
        $index = 0;
        foreach ($event_feedback_sets as $event_feedback_set) {

            if (isset($event_feedback_set->events)) {
                $totalEvents = $event_feedback_set->events->count();
            } else {
                $totalEvents = 0;
            }
            $event_feedback_sets[$index]->totalEvents = $totalEvents;
            $event_feedback_sets[$index]['created_at_toDayDateTimeString'] = date_format(new DateTime($event_feedback_sets[$index]->created_at), 'j/m/Y \(l\) g:ia');
            $event_feedback_sets[$index]['updated_at_toDayDateTimeString'] = date_format(new DateTime($event_feedback_sets[$index]->updated_at), 'j/m/Y \(l\) g:ia');
            $index += 1;
        }


        return datatables()::of($event_feedback_sets)
            ->addColumn('dates', function ($event_feedback_sets) {
                return 'Created At:<br>' . $event_feedback_sets->created_at_toDayDateTimeString . '<br><br> Last Update:<br>' . $event_feedback_sets->updated_at_toDayDateTimeString;
            })
            ->addColumn('events', function ($event_feedback_sets) {
                return 'Total Events: ' . $event_feedback_sets->totalEvents;
            })
            ->addColumn('management_details', function ($event_feedback_sets) {
                return 'Created By: ' . $event_feedback_sets->created_by . '<br> Created At: ' . $event_feedback_sets->created_at;
            })
            ->addColumn('action', function ($event_feedback_sets) {
                return '
                <a href="/event_feedback_sets/' . $event_feedback_sets->id . '" class="btn btn-sm btn-primary">Settings</a>
                <a href="/feedback/form/view/' . $event_feedback_sets->id . '" class="btn btn-sm btn-primary">View Form</a>';
            })
            ->rawColumns(['action', 'management_details', 'events', 'dates'])
            ->make(true);
    }

    public function edit($id)
    {
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
        ], [
            'name.required' => 'Please insert event name',
            'name.max' => 'Name exceed maximum length',
            'description.required' => 'Please insert short course description',
        ]);

        $update = EventFeedbackSet::find($id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'updated_by' => Auth::user()->id,
        ]);

        return Redirect()->back()->with('successUpdate', 'Event Feedback Set Information Updated Successfully');
    }

    public function destroy($id)
    {
    }
}
