<?php

namespace App\Http\Controllers\ShortCourseManagement\EventManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShortCourseManagement\EventParticipant;
use App\Models\ShortCourseManagement\Event;

class EventParticipantController extends Controller
{
    public function show($id)
    {
        //eventParticipantIndex

        $event = Event::find($id);


        //
        return view('short-course-management.event-management.event-participant-show', compact('event'));

    }

    public function dataApplicants($id)
    {
        $eventsParticipants = EventParticipant::where([
            ['event_id', '=', $id],
            ['is_approved_application', '=', 0],
            ['is_disqualified', '=',0]
        ])->get()
            ->load([
                'event',
                'organization_representative',
                'participant.organisations_participants.organisation'
            ]);

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
            ->addColumn('checkApplicant', function ($eventsParticipants) {
                return '<input type="checkbox" name="applicants_checkbox[]" value="' .
                    $eventsParticipants->id .
                    '" class="applicants_checkbox">';
            })
            ->addColumn('action', function ($eventsParticipants) {
                // return '<a href="/event/' . $eventsParticipants->id . '" class="btn btn-sm btn-success">Approved</a>
                //         <a href="/event/' . $eventsParticipants->id . '" class="btn btn-sm btn-danger">Reject</a>';
                return '<a href="#" class="btn btn-sm btn-success">Approve</a>
                        <a href="#" class="btn btn-sm btn-danger">Reject</a>';
            })
            ->rawColumns(['action', 'checkApplicant'])
            ->make(true);
    }
    public function dataNoPaymentYet($id)
    {
        $eventsParticipants = EventParticipant::where([
            ['event_id', '=', $id],
            ['is_approved_application', '=', 1],
            ['is_paid', '=', 0],
            ['is_disqualified', '=',0]
        ])->get()
            ->load([
                'event',
                'organization_representative',
                'participant.organisations_participants.organisation'
            ]);

        $index = 0;
        foreach ($eventsParticipants as $eventParticipant) {
            // $eventsParticipants[$index]->organisations = array();
            // $organization_representative = EventParticipant::find($eventParticipant->organization_representative_id)->load(['participant']);
            // $eventsParticipants[$index]->organization_representative=$organization_representative;
            $eventsParticipants[$index]->created_at_diffForHumans = $eventsParticipants[$index]->created_at->diffForHumans();
            $eventsParticipants[$index]->organisationsString = '';
            foreach ($eventParticipant->participant->organisations_participants as $organisation_participant) {
                // array_push($eventsParticipants[$index]->organisations, $organisation_participant->organisation->name);
                $eventsParticipants[$index]->organisationsString = ($eventsParticipants[$index]->organisationsString) .
                    ($organisation_participant->organisation->name) .
                    '.';
            }
            $index++;
        }

        return datatables()::of($eventsParticipants)
            ->addColumn('checkNoPaymentYet', function ($eventsParticipants) {
                return '<input type="checkbox" name="noPaymentYet_checkbox[]" value="' .
                    $eventsParticipants->id .
                    '" class="noPaymentYet_checkbox">';
            })
            ->addColumn('action', function ($eventsParticipants) {
                return '<a href="#" class="btn btn-sm btn-danger">Disqualified</a>';
            })
            ->rawColumns(['action', 'checkNoPaymentYet'])
            ->make(true);
    }
    public function dataPaymentWaitForVerification($id)
    {
        $eventsParticipants = EventParticipant::where([
            ['event_id', '=', $id],
            ['is_approved_application', '=', 1],
            ['is_paid', '=', 1],
            ['is_verified_payment_proof', '=', 0],
            ['is_disqualified', '=',0]
        ])->get()
            ->load([
                'event',
                'organization_representative',
                'participant.organisations_participants.organisation'
            ]);

        $index = 0;
        foreach ($eventsParticipants as $eventParticipant) {
            // $eventsParticipants[$index]->organisations = array();
            // $organization_representative = EventParticipant::find($eventParticipant->organization_representative_id)->load(['participant']);
            // $eventsParticipants[$index]->organization_representative=$organization_representative;
            $eventsParticipants[$index]->created_at_diffForHumans = $eventsParticipants[$index]->created_at->diffForHumans();
            $eventsParticipants[$index]->organisationsString = '';
            foreach ($eventParticipant->participant->organisations_participants as $organisation_participant) {
                // array_push($eventsParticipants[$index]->organisations, $organisation_participant->organisation->name);
                $eventsParticipants[$index]->organisationsString = ($eventsParticipants[$index]->organisationsString) .
                ($organisation_participant->organisation->name) .
                '.';
            }
            $index++;
        }

        return datatables()::of($eventsParticipants)
            ->addColumn('checkPaymentWaitForVerification', function ($eventsParticipants) {
                return '<input type="checkbox" name="paymentWaitForVerification_checkbox[]" value="' .
                $eventsParticipants->id .
                '" class="paymentWaitForVerification_checkbox">';
            })
            ->addColumn('action', function ($eventsParticipants) {
                return '
                <a href="#" class="btn btn-sm btn-success">Verify</a>
                <a href="#" class="btn btn-sm btn-danger">Reject</a>';
            })
            ->rawColumns(['action', 'checkPaymentWaitForVerification'])
            ->make(true);
    }
    public function dataReadyForEvent($id)
    {
        $eventsParticipants = EventParticipant::where([
            ['event_id', '=', $id],
            ['is_approved_application', '=', 1],
            ['is_paid', '=', 1],
            ['is_verified_payment_proof', '=', 1],
            ['is_disqualified', '=',0]
        ])->get()
            ->load([
                'event',
                'organization_representative',
                'participant.organisations_participants.organisation'
            ]);

        $index = 0;
        foreach ($eventsParticipants as $eventParticipant) {
            // $eventsParticipants[$index]->organisations = array();
            // $organization_representative = EventParticipant::find($eventParticipant->organization_representative_id)->load(['participant']);
            // $eventsParticipants[$index]->organization_representative=$organization_representative;
            $eventsParticipants[$index]->created_at_diffForHumans = $eventsParticipants[$index]->created_at->diffForHumans();
            $eventsParticipants[$index]->organisationsString = '';
            foreach ($eventParticipant->participant->organisations_participants as $organisation_participant) {
                // array_push($eventsParticipants[$index]->organisations, $organisation_participant->organisation->name);
                $eventsParticipants[$index]->organisationsString = ($eventsParticipants[$index]->organisationsString) .
                ($organisation_participant->organisation->name) .
                '.';
            }
            $index++;
        }

        return datatables()::of($eventsParticipants)->make(true);
    }
    public function dataDisqualified($id)
    {
        $eventsParticipants = EventParticipant::where([
            ['event_id', '=', $id],
            ['is_disqualified', '=',1]
        ])->get()
            ->load([
                'event',
                'organization_representative',
                'participant.organisations_participants.organisation'
            ]);

        $index = 0;
        foreach ($eventsParticipants as $eventParticipant) {
            // $eventsParticipants[$index]->organisations = array();
            // $organization_representative = EventParticipant::find($eventParticipant->organization_representative_id)->load(['participant']);
            // $eventsParticipants[$index]->organization_representative=$organization_representative;
            $eventsParticipants[$index]->created_at_diffForHumans = $eventsParticipants[$index]->created_at->diffForHumans();
            $eventsParticipants[$index]->organisationsString = '';
            foreach ($eventParticipant->participant->organisations_participants as $organisation_participant) {
                // array_push($eventsParticipants[$index]->organisations, $organisation_participant->organisation->name);
                $eventsParticipants[$index]->organisationsString = ($eventsParticipants[$index]->organisationsString) .
                ($organisation_participant->organisation->name) .
                '.';
            }
            $index++;
        }

        return datatables()::of($eventsParticipants)->make(true);
    }
    public function dataExpectedAttendances($id)
    {
        $eventsParticipants = EventParticipant::where([
            ['event_id', '=', $id],
            ['is_approved_application', '=', 1],
            ['is_paid', '=', 1],
            ['is_verified_payment_proof', '=', 1],
            ['is_disqualified', '=',0],
            ['is_not_attend', '=',null]
        ])->get()
            ->load([
                'event',
                'organization_representative',
                'participant.organisations_participants.organisation'
            ]);

        $index = 0;
        foreach ($eventsParticipants as $eventParticipant) {
            // $eventsParticipants[$index]->organisations = array();
            // $organization_representative = EventParticipant::find($eventParticipant->organization_representative_id)->load(['participant']);
            // $eventsParticipants[$index]->organization_representative=$organization_representative;
            $eventsParticipants[$index]->created_at_diffForHumans = $eventsParticipants[$index]->created_at->diffForHumans();
            $eventsParticipants[$index]->organisationsString = '';
            foreach ($eventParticipant->participant->organisations_participants as $organisation_participant) {
                // array_push($eventsParticipants[$index]->organisations, $organisation_participant->organisation->name);
                $eventsParticipants[$index]->organisationsString = ($eventsParticipants[$index]->organisationsString) .
                ($organisation_participant->organisation->name) .
                '.';
            }
            $index++;
        }

        return datatables()::of($eventsParticipants)
        ->addColumn('checkExpectedAttendace', function ($eventsParticipants) {
            return '<input type="checkbox" name="expected_attendances_checkbox[]" value="' .
                $eventsParticipants->id .
                '" class="expected_attendances_checkbox">';
        })
        ->addColumn('action', function ($eventsParticipants) {
            // return '<a href="/event/' . $eventsParticipants->id . '" class="btn btn-sm btn-success">Approved</a>
            //         <a href="/event/' . $eventsParticipants->id . '" class="btn btn-sm btn-danger">Reject</a>';
            return '<a href="#" class="btn btn-sm btn-success">Approve</a>
                    <a href="#" class="btn btn-sm btn-danger">Reject</a>';
        })
        ->rawColumns(['action', 'checkExpectedAttendace'])->make(true);
    }
    public function dataAttendedParticipants($id)
    {
        $eventsParticipants = EventParticipant::where([
            ['event_id', '=', $id],
            ['is_approved_application', '=', 1],
            ['is_paid', '=', 1],
            ['is_verified_payment_proof', '=', 1],
            ['is_disqualified', '=',0],
            ['is_not_attend', '=',0]
        ])->get()
            ->load([
                'event',
                'organization_representative',
                'participant.organisations_participants.organisation'
            ]);
        $index = 0;
        foreach ($eventsParticipants as $eventParticipant) {
            // $eventsParticipants[$index]->organisations = array();
            // $organization_representative = EventParticipant::find($eventParticipant->organization_representative_id)->load(['participant']);
            // $eventsParticipants[$index]->organization_representative=$organization_representative;
            $eventsParticipants[$index]->created_at_diffForHumans = $eventsParticipants[$index]->created_at->diffForHumans();
            $eventsParticipants[$index]->organisationsString = '';
            foreach ($eventParticipant->participant->organisations_participants as $organisation_participant) {
                // array_push($eventsParticipants[$index]->organisations, $organisation_participant->organisation->name);
                $eventsParticipants[$index]->organisationsString = ($eventsParticipants[$index]->organisationsString) .
                ($organisation_participant->organisation->name) .
                '.';
            }
            $index++;
        }

        return datatables()::of($eventsParticipants)->make(true);
    }
    public function dataNotAttendedParticipants($id)
    {
        $eventsParticipants = EventParticipant::where([
            ['event_id', '=', $id],
            ['is_approved_application', '=', 1],
            ['is_paid', '=', 1],
            ['is_verified_payment_proof', '=', 1],
            ['is_disqualified', '=',0],
            ['is_not_attend', '=',1]
        ])->get()
            ->load([
                'event',
                'organization_representative',
                'participant.organisations_participants.organisation'
            ]);

        $index = 0;
        foreach ($eventsParticipants as $eventParticipant) {
            // $eventsParticipants[$index]->organisations = array();
            // $organization_representative = EventParticipant::find($eventParticipant->organization_representative_id)->load(['participant']);
            // $eventsParticipants[$index]->organization_representative=$organization_representative;
            $eventsParticipants[$index]->created_at_diffForHumans = $eventsParticipants[$index]->created_at->diffForHumans();
            $eventsParticipants[$index]->organisationsString = '';
            foreach ($eventParticipant->participant->organisations_participants as $organisation_participant) {
                // array_push($eventsParticipants[$index]->organisations, $organisation_participant->organisation->name);
                $eventsParticipants[$index]->organisationsString = ($eventsParticipants[$index]->organisationsString) .
                ($organisation_participant->organisation->name) .
                '.';
            }
            $index++;
        }

        return datatables()::of($eventsParticipants)->make(true);
    }
    public function dataParticipantPostEvent($id)
    {
        $eventsParticipants = EventParticipant::where([
            ['event_id', '=', $id],
            ['is_approved_application', '=', 1],
            ['is_paid', '=', 1],
            ['is_verified_payment_proof', '=', 1],
            ['is_disqualified', '=',0],
            ['is_not_attend', '=',0],
            ['is_done_email_completed', '=',null]
        ])->get()
            ->load([
                'event',
                'organization_representative',
                'participant.organisations_participants.organisation'
            ]);

        $index = 0;
        foreach ($eventsParticipants as $eventParticipant) {
            // $eventsParticipants[$index]->organisations = array();
            // $organization_representative = EventParticipant::find($eventParticipant->organization_representative_id)->load(['participant']);
            // $eventsParticipants[$index]->organization_representative=$organization_representative;
            $eventsParticipants[$index]->created_at_diffForHumans = $eventsParticipants[$index]->created_at->diffForHumans();
            $eventsParticipants[$index]->organisationsString = '';
            foreach ($eventParticipant->participant->organisations_participants as $organisation_participant) {
                // array_push($eventsParticipants[$index]->organisations, $organisation_participant->organisation->name);
                $eventsParticipants[$index]->organisationsString = ($eventsParticipants[$index]->organisationsString) .
                ($organisation_participant->organisation->name) .
                '.';
            }
            $index++;
        }

        return datatables()::of($eventsParticipants)
        ->addColumn('checkParticipantPostEvent', function ($eventsParticipants) {
            return '<input type="checkbox" name="participant_post_event_checkbox[]" value="' .
                $eventsParticipants->id .
                '" class="participant_post_event_checkbox">';
        })
        ->addColumn('action', function ($eventsParticipants) {
            // return '<a href="/event/' . $eventsParticipants->id . '" class="btn btn-sm btn-success">Approved</a>
            //         <a href="/event/' . $eventsParticipants->id . '" class="btn btn-sm btn-danger">Reject</a>';
            return '<a href="#" class="btn btn-sm btn-success">Send Questionaire</a>
                    <a href="#" class="btn btn-sm btn-danger">Ignore Giving Questionaire</a>';
        })
        ->rawColumns(['action', 'checkParticipantPostEvent'])->make(true);
    }

    public function dataCompletedParticipationProcess($id)
    {
        $eventsParticipants = EventParticipant::where([
            ['event_id', '=', $id],
            ['is_approved_application', '=', 1],
            ['is_paid', '=', 1],
            ['is_verified_payment_proof', '=', 1],
            ['is_disqualified', '=',0],
            ['is_not_attend', '=',0],
            ['is_done_email_completed', '=',1]
        ])->get()
            ->load([
                'event',
                'organization_representative',
                'participant.organisations_participants.organisation'
            ]);

        $index = 0;
        foreach ($eventsParticipants as $eventParticipant) {
            // $eventsParticipants[$index]->organisations = array();
            // $organization_representative = EventParticipant::find($eventParticipant->organization_representative_id)->load(['participant']);
            // $eventsParticipants[$index]->organization_representative=$organization_representative;
            $eventsParticipants[$index]->created_at_diffForHumans = $eventsParticipants[$index]->created_at->diffForHumans();
            $eventsParticipants[$index]->organisationsString = '';
            foreach ($eventParticipant->participant->organisations_participants as $organisation_participant) {
                // array_push($eventsParticipants[$index]->organisations, $organisation_participant->organisation->name);
                $eventsParticipants[$index]->organisationsString = ($eventsParticipants[$index]->organisationsString) .
                ($organisation_participant->organisation->name) .
                '.';
            }
            $index++;
        }

        return datatables()::of($eventsParticipants)
        ->addColumn('checkExpectedAttendace', function ($eventsParticipants) {
            return '<input type="checkbox" name="expected_attendances_checkbox[]" value="' .
                $eventsParticipants->id .
                '" class="expected_attendances_checkbox">';
        })
        ->addColumn('action', function ($eventsParticipants) {
            // return '<a href="/event/' . $eventsParticipants->id . '" class="btn btn-sm btn-success">Approved</a>
            //         <a href="/event/' . $eventsParticipants->id . '" class="btn btn-sm btn-danger">Reject</a>';
            return '<a href="#" class="btn btn-sm btn-success">Approve</a>
                    <a href="#" class="btn btn-sm btn-danger">Reject</a>';
        })
        ->rawColumns(['action', 'checkExpectedAttendace'])->make(true);
    }
    public function dataNotCompletedParticipationProcess($id)
    {
        $eventsParticipants = EventParticipant::where([
            ['event_id', '=', $id],
            ['is_approved_application', '=', 1],
            ['is_paid', '=', 1],
            ['is_verified_payment_proof', '=', 1],
            ['is_disqualified', '=',0],
            ['is_not_attend', '=',0],
            ['is_done_email_completed', '=',0]
        ])->get()
            ->load([
                'event',
                'organization_representative',
                'participant.organisations_participants.organisation'
            ]);

        $index = 0;
        foreach ($eventsParticipants as $eventParticipant) {
            // $eventsParticipants[$index]->organisations = array();
            // $organization_representative = EventParticipant::find($eventParticipant->organization_representative_id)->load(['participant']);
            // $eventsParticipants[$index]->organization_representative=$organization_representative;
            $eventsParticipants[$index]->created_at_diffForHumans = $eventsParticipants[$index]->created_at->diffForHumans();
            $eventsParticipants[$index]->organisationsString = '';
            foreach ($eventParticipant->participant->organisations_participants as $organisation_participant) {
                // array_push($eventsParticipants[$index]->organisations, $organisation_participant->organisation->name);
                $eventsParticipants[$index]->organisationsString = ($eventsParticipants[$index]->organisationsString) .
                ($organisation_participant->organisation->name) .
                '.';
            }
            $index++;
        }

        return datatables()::of($eventsParticipants)->make(true);
    }
    public function create()
    {
        //
    }

    public function store(Request $request)
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
