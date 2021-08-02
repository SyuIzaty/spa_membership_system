<?php

namespace App\Http\Controllers\ShortCourseManagement\People\Participant;

use App\Models\ShortCourseManagement\Participant;
use App\Models\ShortCourseManagement\EventParticipant;
use App\Models\ShortCourseManagement\Fee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index()
    {
        //
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
    public function searchByIcGeneral($ic)
    {
        //
        $existParticipant = Participant::where('ic', $ic)->first();

        return $existParticipant;
    }
    public function searchByIcGeneralShow($ic)
    {
        //
        $participant = Participant::where('ic', $ic)->first();

        return view('short-course-management.shortcourse.participant.show', compact('participant'));
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
    public function searchByRepresentativeIc($ic)
    {
        //
        $participant = Participant::where('ic', $ic)->first()->load(['organisations_participants.organisation']);
        return $participant;
    }
}
