<?php

namespace App\Http\Controllers\ShortCourseManagement\EventManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShortCourseManagement\EventParticipant;

class EventParticipantController extends Controller
{
    public function index()
    {
        //
    }
    public function data($id)
    {
        // return $id;
        $eventsParticipants = EventParticipant::where('event_id', $id)->get()->load(['event', 'participant', 'organization_representative', 'participant.organisations_participants', 'participant.organisations_participants.organisation']);

        $index = 0;
        foreach ($eventsParticipants as $eventParticipant) {
            // $eventsParticipants[$index]->organisations = array();
            // $organization_representative = EventParticipant::find($eventParticipant->organization_representative_id)->load(['participant']);
            // $eventsParticipants[$index]->organization_representative=$organization_representative;
            $eventsParticipants[$index]->created_at_diffForHumans = $eventsParticipants[$index]->created_at->diffForHumans();
            $eventsParticipants[$index]->organisationsString = '';
            foreach ($eventParticipant->participant->organisations_participants as $organisation_participant) {
                // array_push($eventsParticipants[$index]->organisations, $organisation_participant->organisation->name);
                $eventsParticipants[$index]->organisationsString = ($eventsParticipants[$index]->organisationsString) . ($organisation_participant->organisation->name) . '.';
            }
            $index++;
        }

        return datatables()::of($eventsParticipants)
            ->addColumn('checkapplicant', function ($eventsParticipants) {
                return '<input type="checkbox" name="applicants_checkbox[]" value="' . $eventsParticipants->id . '" class="applicants_checkbox">';
            })
            ->addColumn('action', function ($eventsParticipants) {
                // return '<a href="/event/' . $eventsParticipants->id . '" class="btn btn-sm btn-success">Approved</a>
                //         <a href="/event/' . $eventsParticipants->id . '" class="btn btn-sm btn-danger">Reject</a>';
                return '<a href="#" class="btn btn-sm btn-success">Approved</a>
                        <a href="#" class="btn btn-sm btn-danger">Reject</a>';
            })
            ->rawColumns(['action', 'checkapplicant'])
            ->make(true);
    }
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
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
