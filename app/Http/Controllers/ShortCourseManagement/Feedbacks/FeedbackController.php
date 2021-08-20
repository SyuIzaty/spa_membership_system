<?php

namespace App\Http\Controllers\ShortCourseManagement\Feedbacks;

use App\Models\ShortCourseManagement\Question;
use App\Models\ShortCourseManagement\Section;
use App\Models\ShortCourseManagement\EventParticipant;
use App\Models\ShortCourseManagement\EventParticipantQuestionAnswer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function form()
    {
        //
        $sections = Section::all()->load(['questions']);
        // $index = 0;
        // foreach ($sections as $section) {
        //     $sections[$index]['questions'] = Question::where('section_id', $section->id)->first();
        //     $index++;
        // }
        return view('short-course-management.feedback.index', compact('sections'));
    }

    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        //
    }
    public function show($event_participant_id)
    {
        //
        $event_participant_question_id = EventParticipantQuestionAnswer::where('event_participant_id', $event_participant_id)->first();
        // scm_event_participant_question_answer
        if (!$event_participant_question_id) {
            $sections = Section::all()->load(['questions']);
            $event_participant = EventParticipant::find($event_participant_id)->load(['Participant', 'Event']);
            return view('short-course-management.feedback.index', compact('sections', 'event_participant'));
        } else {
            return redirect('/feedback/appreciation');
        }
    }

    public function submit(Request $request)
    {
        //
        $sections = Section::all()->load(['questions']);
        $rules = array();
        foreach ($sections as $section) {
            foreach ($section->questions as $question) {
                $rules["q" . strtoupper(substr($question->question_type, 0, 4)) . strval($question->id)] = 'required';
            }
        }

        $validated = $request->validate($rules);
        $event_participant_question_id = EventParticipantQuestionAnswer::where('event_participant_id', $request->event_participant_id)->first();
        // scm_event_participant_question_answer
        $data = $request->all();
        // // dd($data);
        // foreach ($data as $key => $value) {
        //     return $value;
        // }

        if (!$event_participant_question_id) {
            foreach ($request->all() as $key => $value) {
                $input_type = substr($key, 0, 1);
                if (strcmp($input_type, 'q')==0) {
                    $input_type2 = substr($key, 1, 4);
                    $question_id = substr($key, 5);
                    if (strcmp($input_type2, 'RATE')==0) {
                        // dd($question_id)
                        EventParticipantQuestionAnswer::create([
                            'question_id' => $question_id,
                            'event_participant_id' => $request->event_participant_id,
                            'rate' => $value,
                            'description' => null,
                            'created_by' => 'public_user',
                        ]);
                    } else if (strcmp($input_type2, 'TEXT')==0) {
                        // dd($question_id)
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
        }
        // return view('short-course-management.feedback.appreciation');
        return redirect('/feedback/appreciation');
    }
    public function appreciation()
    {
        return view('short-course-management.feedback.appreciation');
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
