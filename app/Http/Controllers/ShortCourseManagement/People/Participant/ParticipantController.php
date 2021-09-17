<?php

namespace App\Http\Controllers\ShortCourseManagement\People\Participant;

use App\Models\ShortCourseManagement\Participant;
use App\Models\ShortCourseManagement\EventParticipant;
use App\Models\ShortCourseManagement\Fee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;
use Auth;

class ParticipantController extends Controller
{
    public function index()
    {
        //
        $participants = Participant::all();
        return view('short-course-management.people.participant.index', compact('participants'));
    }

    public function dataParticipants()
    {
        $participants = Participant::orderByDesc('id')->get()->load(['events_participants']);
        $index = 0;
        foreach ($participants as $participant) {

            if (isset($participant->events_participants)) {
                $totalEvents = $participant->events_participants->count();
            } else {
                $totalEvents = 0;
            }
            $participants[$index]->totalEvents = $totalEvents;
            $participants[$index]['created_at_toDayDateTimeString'] = date_format(new DateTime($participants[$index]->created_at), 'g:ia \o\n l jS F Y');
            $participants[$index]['updated_at_toDayDateTimeString'] = date_format(new DateTime($participants[$index]->updated_at), 'g:ia \o\n l jS F Y');
            $index += 1;
        }


        return datatables()::of($participants)
            ->addColumn('dates', function ($participants) {
                return 'Created At:<br>' . $participants->created_at_toDayDateTimeString . '<br><br> Last Update:<br>' . $participants->updated_at_toDayDateTimeString;
            })
            ->addColumn('events_participants', function ($participants) {
                return 'Total Events: ' . $participants->totalEvents;
            })
            ->addColumn('management_details', function ($participants) {
                return 'Created By: ' . $participants->created_by . '<br> Created At: ' . $participants->created_at;
            })
            ->addColumn('action', function ($participants) {
                return '
                <a href="/participants/' . $participants->id . '" class="btn btn-sm btn-primary">Settings</a>';
            })
            ->rawColumns(['action', 'management_details', 'events_participants', 'dates'])
            ->make(true);
    }

    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'participant_ic_input' => 'required',
            'participant_fullname' => 'required|min:3',
            'participant_phone' => 'required|min:10',
            'participant_email' => 'required|email:rfc'

        ], [
            'participant_ic_input.required' => 'Please insert IC of the participant',
            'participant_fullname.required' => 'Please insert participant fullname of the participant',
            'participant_fullname.min' => 'The participant fullname should have at least 3 characters',
            'participant_phone.required' => 'Please insert participant phone number of the participant',
            'participant_phone.min' => 'The participant phone number should have at least 10 characters',
            'participant_email.required' => "Please insert email address of the participant"
        ]);

        $existParticipant = Participant::where([
            ['ic', '=', $request->participant_ic_input],
        ])->first();
        if (!$existParticipant) {

            $sha1_ic = sha1($request->participant_ic_input);
            $existParticipant = Participant::create([
                'name' => $request->participant_fullname,
                'ic' => $request->participant_ic_input,
                'sha1_ic' => $sha1_ic,
                'phone' => $request->participant_phone,
                'email' => $request->participant_email,
                'created_by' => Auth::user()->id,
            ]);
        } else {
            $sha1_ic = sha1($request->participant_ic_input);
            $existParticipant->name = $request->participant_fullname;
            $existParticipant->ic = $request->participant_ic_input;
            $existParticipant->sha1_ic = $sha1_ic;
            $existParticipant->phone = $request->participant_phone;
            $existParticipant->email = $request->participant_email;
            $existParticipant->updated_by = Auth::user()->id;
            $existParticipant->save();
            return Redirect()->back()->with('messageAlreadyApplied', 'The participant detail have been updated before.');
        }
        $participant = Participant::find($existParticipant->id)->load([
            'events_participants',
        ]);
        if (isset($participant->events_participants)) {
            $totalEvents = $participant->events_participants->count();
        } else {
            $totalEvents = 0;
        }
        $participant->totalEvents = $totalEvents;
        return redirect('/participants/' . $existParticipant->id)->with(compact('existParticipant'));
    }
    public function show($id)
    {

        $participant = Participant::find($id)->load([
            'events_participants',
        ]);


        if (isset($participant->events_participants)) {
            $totalEvents = $participant->events_participants->count();
        } else {
            $totalEvents = 0;
        }
        $participant->totalEvents = $totalEvents;

        return view('short-course-management.people.participant.show', compact('participant',));
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
            'email' => 'required',
            'ic' => 'required',
            'phone' => 'required',
        ], [
            'name.required' => 'Please insert event name',
            'name.max' => 'Name exceed maximum length',
            'email.required' => 'Please insert event email',
            'ic.required' => 'Please insert event ic',
            'phone.required' => 'Please insert event phone',
        ]);


        $sha1_ic = sha1($request->ic);
        //return true or false
        $updateParticipant = Participant::find($id)->update([
            'ic' => $request->ic,
            'sha1_ic' => $sha1_ic,
            'phone' => $request->phone,
            'name' => $request->name,
            'email' => $request->email,
            'updated_by' => Auth::user()->id,
        ]);

        return Redirect()->back()->with('updateSuccess', 'Participant Information Updated Successfully');
    }

    public function destroy($id)
    {
        //
    }
    public function searchByIcGeneral($ic)
    {
        //
        $existParticipant = Participant::where('ic', $ic)->first();

        return $existParticipant;
    }
    public function searchByIcGeneralShow($sha1_ic)
    {
        //
        $participant = Participant::where('sha1_ic', $sha1_ic)->first();

        return view('short-course-management.shortcourse.participant.show', compact('participant'));
    }
    public function hashIc($ic)
    {
        //
        return sha1($ic);
    }
    public function searchByIc($ic, $event_id)
    {
        //
        $existParticipant = Participant::where('ic', $ic)->first();
        if ($existParticipant) {
            $existParticipant = Participant::where('ic', $ic)->first()->load(['organisations_participants.organisation']);
            $eventParticipant = EventParticipant::where([
                ['event_id', '=', $event_id],
                ['participant_id', '=', $existParticipant->id],
            ])->first();
            if ($eventParticipant) {
                $eventParticipant = EventParticipant::where([
                    ['event_id', '=', $event_id],
                    ['participant_id', '=', $existParticipant->id],
                ])->first()->load(['participant.organisations_participants.organisation', 'fee']);
            } else {
                $fee = Fee::where([
                    ['event_id', '=', $event_id],
                    ['is_base_fee', '=', 1]
                ])->orderBy('amount', 'desc')->orderBy('created_at', 'desc')->first();
                $eventParticipant['participant'] = $existParticipant;
                $eventParticipant['fee_id'] = $fee->id;
                $eventParticipant['fee'] = $fee;
            }
        } else {
            $eventParticipant = null;

            $fee = Fee::where([
                ['event_id', '=', $event_id],
                ['is_base_fee', '=', 1]
            ])->orderBy('amount', 'desc')->orderBy('created_at', 'desc')->first();
            $eventParticipant['participant'] = $existParticipant;
            $eventParticipant['fee_id'] = $fee->id;
            $eventParticipant['fee'] = $fee;
        }
        return $eventParticipant;
    }

    public function searchByParticipantIc($ic)
    {
        //
        $existParticipant = Participant::where('ic', $ic)->first();

        return $existParticipant;
    }
    public function searchByRepresentativeIc($ic)
    {
        //
        $participant = Participant::where('ic', $ic)->first()->load(['organisations_participants.organisation']);
        return $participant;
    }

    public function delete(Request $request, $id)
    {

        $exist = Participant::find($id);
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
}
