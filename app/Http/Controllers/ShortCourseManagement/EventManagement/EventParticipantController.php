<?php

namespace App\Http\Controllers\ShortCourseManagement\EventManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShortCourseManagement\EventParticipant;
use App\Models\ShortCourseManagement\Event;
use App\Models\ShortCourseManagement\Participant;
use App\Models\ShortCourseManagement\Fee;
use App\Models\ShortCourseManagement\EventParticipantPaymentProof;
use Auth;
use DateTime;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

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
            ['is_disqualified', '=', 0]
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
                return '<a href="javascript:;" id="approve-application" data-remote="/update-progress/approve-application/' . $eventsParticipants->id . '" class="btn btn-sm btn-success btn-update-progress">Approve</a>
                        <a href="javascript:;" id="reject-application" data-remote="/update-progress/reject-application/' . $eventsParticipants->id . '" class="btn btn-sm btn-danger btn-update-progress">Reject</a>';
            })
            ->rawColumns(['action', 'checkApplicant'])
            ->make(true);
    }
    public function dataNoPaymentYet($id)
    {
        $eventsParticipants = EventParticipant::where([
            ['event_id', '=', $id],
            ['is_approved_application', '=', 1],
            ['is_verified_payment_proof', '=', null],
            ['is_disqualified', '=', 0]
        ])->get()
            ->load([
                'event',
                'organization_representative',
                'participant.organisations_participants.organisation',
                'fee'
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
                return '
                <a href="#" data-target="#crud-modals" data-toggle="modal" data-event_id="' . $eventsParticipants->event_id . '" data-event_participant_id="' . $eventsParticipants->id . '" data-participant_id="' . $eventsParticipants->participant_id . '" data-is_verified_payment_proof="' . $eventsParticipants->is_verified_payment_proof . '" data-amount="' . $eventsParticipants->fee->amount . '" class="btn btn-sm btn-primary">Update Payment Proof</a>
                <a href="javascript:;" id="disqualified-application-no-payment" data-remote="/update-progress/disqualified-application-no-payment/' . $eventsParticipants->id . '" class="btn btn-sm btn-danger btn-update-progress">Disqualified</a>';
            })
            ->rawColumns(['action', 'checkNoPaymentYet'])
            ->make(true);
    }
    public function dataPaymentWaitForVerification($id)
    {
        $eventsParticipants = EventParticipant::where([
            ['event_id', '=', $id],
            ['is_approved_application', '=', 1],
            ['is_verified_payment_proof', '=', 0],
            ['is_verified_payment_proof', '=', 0],
            ['is_disqualified', '=', 0]
        ])->get()
            ->load([
                'event',
                'organization_representative',
                'participant.organisations_participants.organisation',
                'fee'
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
            ->addColumn('proof', function ($eventsParticipants) {
                return '
                <a href="#" data-target="#crud-modals-view-proof" data-toggle="modal" data-event_id="' . $eventsParticipants->event_id . '" data-event_participant_id="' . $eventsParticipants->id . '" data-participant_id="' . $eventsParticipants->participant_id . '" data-amount="' . $eventsParticipants->fee->amount . '" class="btn btn-sm btn-primary">View</a>';
            })
            ->addColumn('action', function ($eventsParticipants) {
                return '
                <a href="javascript:;" id="verify-payment-proof" data-remote="/update-progress/verify-payment-proof/' . $eventsParticipants->id . '" class="btn btn-sm btn-success btn-update-progress">Verify</a>
                <a href="javascript:;" id="reject-payment-proof" data-remote="/update-progress/reject-payment-proof/' . $eventsParticipants->id . '" class="btn btn-sm btn-danger btn-update-progress">Reject</a>';
            })
            ->rawColumns(['action', 'proof', 'checkPaymentWaitForVerification'])
            ->make(true);
    }
    public function dataReadyForEvent($id)
    {
        $eventsParticipants = EventParticipant::where([
            ['event_id', '=', $id],
            ['is_approved_application', '=', 1],
            ['is_verified_payment_proof', '=', 1],
            ['is_verified_payment_proof', '=', 1],
            ['is_verified_approved_participation', '=', 1],
            ['is_disqualified', '=', 0]
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
            ['is_disqualified', '=', 1]
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
            ['is_verified_payment_proof', '=', 1],
            ['is_verified_payment_proof', '=', 1],
            ['is_disqualified', '=', 0],
            // ['is_not_attend', '=', null]
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
            // dd($eventParticipant->is_not_attend);
            $eventParticipant['attendance_status'] = (is_null($eventParticipant->is_not_attend) ? "No Status Yet" : ($eventParticipant->is_not_attend === 0 ? 'Attend' : 'Not Attend'));

            $eventParticipant['send_question'] = (is_null($eventParticipant->is_question_sended) ? "Not Send Yet" : ($eventParticipant->is_question_sended === 0 ? 'Not Send Yet' : 'Sent'));

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
                $buttonString = '';

                if (is_null($eventsParticipants->is_not_attend)) {
                    $buttonString .= '<a href="javascript:;" id="verify-attendance-attend" data-remote="/update-progress/verify-attendance-attend/' . $eventsParticipants->id . '" class="btn btn-sm btn-success btn-update-progress">Attend</a>
                        <a href="javascript:;" id="verify-attendance-not-attend" data-remote="/update-progress/verify-attendance-not-attend/' . $eventsParticipants->id . '" class="btn btn-sm btn-danger btn-update-progress">Not Attend</a>';
                } else if ($eventsParticipants->is_not_attend === 0) {
                    $buttonString .= '<a href="javascript:;" id="verify-attendance-not-attend" data-remote="/update-progress/verify-attendance-not-attend/' . $eventsParticipants->id . '" class="btn btn-sm btn-danger btn-update-progress">Not Attend</a>';

                    // if (is_null($eventsParticipants->is_question_sended)) {
                    //     $buttonString .= ' <a href="javascript:;" id="send-question" data-remote="/update-progress/send-question/' . $eventsParticipants->id . '" class="btn btn-sm btn-success btn-update-progress">Send Questionaire</a>';
                    // }
                } else if ($eventsParticipants->is_not_attend === 1) {
                    $buttonString .= '<a href="javascript:;" id="verify-attendance-attend" data-remote="/update-progress/verify-attendance-attend/' . $eventsParticipants->id . '" class="btn btn-sm btn-success btn-update-progress">Attend</a>';
                }
                return $buttonString;
            })
            ->rawColumns(['action', 'checkExpectedAttendace'])->make(true);
    }
    public function dataAttendedParticipants($id)
    {
        $eventsParticipants = EventParticipant::where([
            ['event_id', '=', $id],
            ['is_approved_application', '=', 1],
            ['is_verified_payment_proof', '=', 1],
            ['is_verified_payment_proof', '=', 1],
            ['is_disqualified', '=', 0],
            ['is_not_attend', '=', 0]
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
            ['is_verified_payment_proof', '=', 1],
            ['is_verified_payment_proof', '=', 1],
            ['is_disqualified', '=', 0],
            ['is_not_attend', '=', 1]
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
            ['is_verified_payment_proof', '=', 1],
            ['is_verified_payment_proof', '=', 1],
            ['is_disqualified', '=', 0],
            ['is_not_attend', '=', 0],
            ['is_question_sended', '=', 0],
            ['is_done_email_completed', '=', null]
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
                return '<a href="javascript:;" id="send-question" data-remote="/update-progress/send-question/' . $eventsParticipants->id . '" class="btn btn-sm btn-success btn-update-progress">Send Questionaire</a>';
            })
            ->rawColumns(['action', 'checkParticipantPostEvent'])->make(true);
    }

    public function dataCompletedParticipationProcess($id)
    {
        $eventsParticipants = EventParticipant::where([
            ['event_id', '=', $id],
            ['is_approved_application', '=', 1],
            ['is_verified_payment_proof', '=', 1],
            ['is_verified_payment_proof', '=', 1],
            ['is_disqualified', '=', 0],
            ['is_not_attend', '=', 0],
            ['is_question_sended', '=', 1],
            // ['is_done_email_completed', '=', 1]
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
            if ($eventsParticipants[$index]->is_done_email_completed == 1) {
                $eventsParticipants[$index]->done_email_completed_datetime_diffForHumans = $eventsParticipants[$index]->done_email_completed_datetime->diffForHumans();
            } else {
                $eventsParticipants[$index]->done_email_completed_datetime_diffForHumans = $eventsParticipants[$index]->done_email_completed_datetime;
            }
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
    public function dataNotCompletedParticipationProcess($id)
    {
        $eventsParticipants = EventParticipant::where([
            ['event_id', '=', $id],
            ['is_approved_application', '=', 1],
            ['is_verified_payment_proof', '=', 1],
            ['is_verified_payment_proof', '=', 1],
            ['is_disqualified', '=', 0],
            ['is_not_attend', '=', 0],
            ['is_question_sended', '=', 1],
            ['is_done_email_completed', '=', 0]
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

    public function store(Request $request, $event_id)
    {
        $validated = $request->validate([
            'ic_input' => 'required',
            'fullname' => 'required|min:3',
            'phone' => 'required|min:10',
            'email' => 'required|email:rfc',
            'fee_id' => 'required',
            'representative_ic_input'  => 'required',
            'representative_fullname' => 'required',

        ], [
            'ic_input.required' => 'Please insert IC of the participant',
            'fullname.required' => 'Please insert fullname of the participant',
            'fullname.min' => 'The fullname should have at least 3 characters',
            'phone.required' => 'Please insert phone number of the participant',
            'phone.min' => 'The phone number should have at least 10 characters',
            'email.required' => "Please insert email address of the participant",
            'fee_id.required' => 'Please choose the fee applicable for the participant',
            'representative_fullname.required' => 'Please insert the representative fullname of the participant',
            'representative_ic_input.required' => "Please insert the representative's IC of the participant",
            'representative_fullname.min' => "The representative's fullname should have at least 3 characters",
        ]);

        // dd($request);
        //
        $existParticipant = Participant::where([
            ['ic', '=', $request->ic_input],
        ])->first();
        if (!$existParticipant) {
            $existParticipant = Participant::create([
                'name' => $request->fullname,
                'ic' => $request->ic_input,
                'phone' => $request->phone,
                'email' => $request->email,
                'created_by' => Auth::user()->id,
            ]);
        } else {
            $existParticipant->name = $request->fullname;
            $existParticipant->ic = $request->ic_input;
            $existParticipant->phone = $request->phone;
            $existParticipant->email = $request->email;
            $existParticipant->updated_by = Auth::user()->id;
            $existParticipant->save();
        }


        $existEventParticipant = EventParticipant::where([
            ['event_id', '=', $event_id],
            ['participant_id', '=', $existParticipant->id],
        ])->first();

        if (!$existEventParticipant) {
            $existEventParticipant = EventParticipant::create([
                'event_id' => $event_id,
                'participant_id' => $existParticipant->id,
                'fee_id' => $request->fee_id,
                'participant_representative_id' => $existParticipant->id,
                'is_approved_application' => 1,
                'created_by' => Auth::user()->id,
            ]);
        } else {
            $existEventParticipant->fee_id = $request->fee_id;
            $existEventParticipant->updated_by = Auth::user()->id;
            $existEventParticipant->save();
            return Redirect()->back()->with('messageAlreadyApplied', 'The participant have already been applied before.');
        }
        $existEvent = Event::where('id', $event_id)->first()->load(['venue']);
        $existFee = Fee::where('id', $request->fee_id)->first();


        $message =  [
            'opening' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . ($existParticipant->name),
            'introduction' => 'Pendaftaran anda <b>TELAH DISAHKAN BERJAYA</b> oleh pihak INTEC bagi program, ',
            'detail' => 'Program: ' . ($existEvent->name)
                . '<br/>Tarikh: ' . ($existEvent->datetime_start) . ' sehingga ' . ($existEvent->datetime_end)
                . '<br/>Tempat: ' . ($existEvent->venue->name)
                . '<br/> <br/>Sila buat pembayaran yuran sebanyak <b>RM'
                . ($existFee->amount) . ' (' . ($existFee->name)
                . ')</b>, kemudian tekan butang di bawah untuk ke sesawang profil bagi mengemaskini status pembayaran untuk disahkan.',
            'conclusion' => 'Kami amat menghargai segala usaha anda. Semoga urusan anda dipermudahkan. Terima kasih.',
            'ic' => ($existParticipant->ic),
        ];

        Mail::send('short-course-management.email.email-payment-verified', $message, function ($message) use ($request) {
            $message->subject('Pengesahan Pendaftaran (Berjaya)');
            $message->from(Auth::user()->email);
            $message->to($request->email);
        });
        return Redirect()->back()->with('messageNewApplication', 'New participant applied successfully');
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

    public function applyPromoCode($event_id, $promo_code)
    {
        //
        $existFee = null;
        if ($promo_code != null && $promo_code != '') {
            $existFee = Fee::where([
                ['event_id', '=', $event_id],
                ['promo_code', '=', $promo_code],
            ])->first();

            $fee = null;

            if ($existFee) {
                $fee['fee_id'] = $existFee->id;
                $fee['fee'] = $existFee;
            }
        }

        return $fee;
    }
    public function baseFee($event_id)
    {
        //
        $existFee = Fee::where([
            ['event_id', '=', $event_id],
            ['is_base_fee', '=', 1]
        ])->orderBy('amount', 'desc')->orderBy('created_at', 'desc')->first();
        $fee['fee_id'] = $existFee->id;
        $fee['fee'] = $existFee;
        return $fee;
    }

    public function updateProgress($progress_name, $eventParticipant_id)
    {
        $eventParticipant = EventParticipant::where('id', $eventParticipant_id)->first()->load(['participant', 'event.venue', 'fee']);

        switch ($progress_name) {
            case 'approve-application':
                $update = EventParticipant::find($eventParticipant_id)->update([
                    'is_approved_application' => 1,
                    'approved_application_datetime' => Carbon::now(),
                ]);
                $message =  [
                    'opening' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . ($eventParticipant->participant->name),
                    'introduction' => 'Pendaftaran anda <b>TELAH DISAHKAN BERJAYA</b> oleh pihak INTEC bagi program, ',
                    'detail' => 'Program: ' . ($eventParticipant->event->name)
                        . '<br/>Tarikh: ' . ($eventParticipant->event->datetime_start) . ' sehingga ' . ($eventParticipant->event->datetime_end)
                        . '<br/>Tempat: ' . ($eventParticipant->event->venue->name)
                        . '<br/> <br/>Sila buat pembayaran yuran sebanyak <b>RM'
                        . ($eventParticipant->fee->amount) . ' (' . ($eventParticipant->fee->name)
                        . ')</b>, kemudian tekan butang di bawah untuk ke sesawang profil bagi mengemaskini status pembayaran untuk disahkan.',
                    'conclusion' => 'Kami amat menghargai segala usaha anda. Semoga urusan anda dipermudahkan. Terima kasih.',
                    'ic' => ($eventParticipant->participant->ic),
                ];

                Mail::send('short-course-management.email.email-payment-verified', $message, function ($message) use ($eventParticipant) {
                    $message->subject('Pengesahan Pendaftaran (Berjaya)');
                    $message->from(Auth::user()->email);
                    $message->to($eventParticipant->participant->email);
                });
                break;
            case 'reject-application':
                $exist = EventParticipant::find($eventParticipant_id);
                $exist->updated_by = Auth::user()->id;
                $exist->deleted_by = Auth::user()->id;
                $exist->save();
                $exist->delete();

                $message =  [
                    'opening' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . ($eventParticipant->participant->name),
                    'introduction' => 'Sebagai makluman, pendaftaran anda <b>TELAH DITOLAK</b> oleh pihak INTEC bagi program, ',
                    'detail' => 'Program: ' . ($eventParticipant->event->name)
                        . '<br/>Tarikh: ' . ($eventParticipant->event->datetime_start) . ' sehingga ' . ($eventParticipant->event->datetime_end)
                        . '<br/>Tempat: ' . ($eventParticipant->event->venue->name)
                        . '<br/> <br/>Jika ini adalah suatu kesilapan, sila hubungi pihak kami semula.',
                    'conclusion' => 'Kami amat menghargai segala usaha anda. Semoga urusan anda dipermudahkan. Terima kasih.',
                    'ic' => ($eventParticipant->participant->ic),
                ];

                Mail::send('short-course-management.email.email-payment-verified', $message, function ($message) use ($eventParticipant) {
                    $message->subject('Pengesahan Pendaftaran (Tidak Berjaya)');
                    $message->from(Auth::user()->email);
                    $message->to($eventParticipant->participant->email);
                });
                break;
            case 'disqualified-application-no-payment':
                $update = EventParticipant::find($eventParticipant_id)->update([
                    'is_disqualified' => 1,
                    'disqualified_datetime' => Carbon::now(),
                ]);

                $message =  [
                    'opening' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . ($eventParticipant->participant->name),
                    'introduction' => 'Sebagai makluman, pendaftaran anda <b>TELAH DITOLAK</b> oleh pihak INTEC bagi program, ',
                    'detail' => 'Program: ' . ($eventParticipant->event->name)
                        . '<br/>Tarikh: ' . ($eventParticipant->event->datetime_start) . ' sehingga ' . ($eventParticipant->event->datetime_end)
                        . '<br/>Tempat: ' . ($eventParticipant->event->venue->name)
                        . '<br/> <br/>Jika ini adalah suatu kesilapan, sila hubungi pihak kami semula.',
                    'conclusion' => 'Kami amat menghargai segala usaha anda. Semoga urusan anda dipermudahkan. Terima kasih.',
                    'ic' => ($eventParticipant->participant->ic),
                ];

                Mail::send('short-course-management.email.email-payment-verified', $message, function ($message) use ($eventParticipant) {
                    $message->subject('Pengesahan Pendaftaran (Tidak Berjaya)');
                    $message->from(Auth::user()->email);
                    $message->to($eventParticipant->participant->email);
                });
                break;
            case 'verify-payment-proof':
                $update = EventParticipant::find($eventParticipant_id)->update([
                    'is_verified_payment_proof' => 1,
                    'is_verified_approved_participation' => 1,
                    'approved_participation_datetime' => Carbon::now(),
                    'verified_payment_proof_datetime' => Carbon::now(),
                ]);

                $message =  [
                    'opening' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . ($eventParticipant->participant->name),
                    'introduction' => 'Bukti pembayaran anda <b>TELAH DISAHKAN</b> oleh pihak INTEC bagi program, ',
                    'detail' => 'Program: ' . ($eventParticipant->event->name)
                        . '<br/>Tarikh: ' . ($eventParticipant->event->datetime_start) . ' sehingga ' . ($eventParticipant->event->datetime_end)
                        . '<br/>Tempat: ' . ($eventParticipant->event->venue->name),
                    'conclusion' => 'Kami amat menghargai segala usaha anda. Semoga urusan anda dipermudahkan. Terima kasih.',
                    'ic' => ($eventParticipant->participant->ic),
                ];

                Mail::send('short-course-management.email.email-payment-verified', $message, function ($message) use ($eventParticipant) {
                    $message->subject('Pengesahan Bukti Pembayaran (Disahkan Berjaya)');
                    $message->from(Auth::user()->email);
                    $message->to($eventParticipant->participant->email);
                });
                break;
            case 'reject-payment-proof':
                $update = EventParticipant::find($eventParticipant_id)->update([
                    'is_verified_payment_proof' => null,
                    'verified_payment_proof_datetime' => null,
                ]);

                $message =  [
                    'opening' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . ($eventParticipant->participant->name),
                    'introduction' => 'Sebagai makluman, bukti pembayaran anda <b>TELAH DITOLAK</b> oleh pihak INTEC bagi program, ',
                    'detail' => 'Program: ' . ($eventParticipant->event->name)
                        . '<br/>Tarikh: ' . ($eventParticipant->event->datetime_start) . ' sehingga ' . ($eventParticipant->event->datetime_end)
                        . '<br/>Tempat: ' . ($eventParticipant->event->venue->name)
                        . '<br/> <br/>Sila buat pembayaran yuran sebanyak <b>RM'
                        . ($eventParticipant->fee->amount) . ' (' . ($eventParticipant->fee->name)
                        . ')</b>, kemudian tekan butang di bawah untuk ke sesawang profil bagi memasukkan bukti pembayaran yang baharu untuk disahkan.',
                    'conclusion' => 'Kami amat menghargai segala usaha anda. Semoga urusan anda dipermudahkan. Terima kasih.',
                    'ic' => ($eventParticipant->participant->ic),
                ];

                Mail::send('short-course-management.email.email-payment-verified', $message, function ($message) use ($eventParticipant) {
                    $message->subject('Pengesahan Pembayaran (Tidak Berjaya)');
                    $message->from(Auth::user()->email);
                    $message->to($eventParticipant->participant->email);
                });
                break;
            case 'verify-attendance-attend':
                $update = EventParticipant::find($eventParticipant_id)->update([
                    'is_not_attend' => 0,
                    'is_question_sended' => 1,
                    'question_sended_datetime' => Carbon::now(),
                    'is_done_email_completed' => 0,
                ]);
                // $message =  [
                //     'opening' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik '+ ($eventParticipant->participant->name),
                //     'content' => 'Tahniah! Anda telah disahkan sebagai hadir bagi program ' + ($eventParticipant->event->name)
                //     + ' yang dianjurkan oleh INTEC pada ' + ($eventParticipant->event->datetime_start) + ' sehingga '+ ($eventParticipant->event->datetime_end)
                //     + ' di ' + ($eventParticipant->event->venue->name) +'. Kami amat menghargai segala usaha anda. Semoga anda terus berjaya. Terima kasih.',
                // ];
                // dd($eventParticipant);

                $message =  [
                    'opening' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . ($eventParticipant->participant->name),
                    'introduction' => 'Tahniah! Anda telah disahkan sebagai <b>HADIR</b> bagi program, ',
                    'detail' => 'Program: ' . ($eventParticipant->event->name)
                        . '<br/>Tarikh: ' . ($eventParticipant->event->datetime_start) . ' sehingga ' . ($eventParticipant->event->datetime_end)
                        . '<br/>Tempat: ' . ($eventParticipant->event->venue->name),
                    'conclusion' => 'Kami amat menghargai segala usaha anda. Semoga anda terus berjaya. Terima kasih.',
                    'ic' => ($eventParticipant->participant->ic),
                    'event_participant_id' => ($eventParticipant->id),
                ];

                Mail::send('short-course-management.email.email-payment-verified', $message, function ($message) use ($eventParticipant) {
                    $message->subject('Pengesahan Kehadiran (Hadir)');
                    $message->from(Auth::user()->email);
                    $message->to($eventParticipant->participant->email);
                });
                break;
            case 'verify-attendance-not-attend':
                $update = EventParticipant::find($eventParticipant_id)->update([
                    'is_not_attend' => 1,
                ]);

                $message =  [
                    'opening' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . ($eventParticipant->participant->name),
                    'introduction' => 'Anda telah disahkan sebagai <b>TIDAK HADIR</b> bagi program, ',
                    'detail' => 'Program: ' . ($eventParticipant->event->name)
                        . '<br/>Tarikh: ' . ($eventParticipant->event->datetime_start) . ' sehingga ' . ($eventParticipant->event->datetime_end)
                        . '<br/>Tempat: ' . ($eventParticipant->event->venue->name),
                    'conclusion' => 'Sila maklumkan kepada kami sekiranya ini adalah suatu kesilapan. Terima kasih.',
                    'ic' => ($eventParticipant->participant->ic),
                ];

                Mail::send('short-course-management.email.email-payment-verified', $message, function ($message) use ($eventParticipant) {
                    $message->subject('Pengesahan Kehadiran (Tidak Hadir)');
                    $message->from(Auth::user()->email);
                    $message->to($eventParticipant->participant->email);
                });
                break;
            case 'send-question':
                $update = EventParticipant::find($eventParticipant_id)->update([
                    'is_question_sended' => 1,
                    'question_sended_datetime' => Carbon::now(),
                    'is_done_email_completed' => 0,
                ]);
                break;
            default:
                break;
        }
    }

    public function updateProgressBundle(Request $request)
    {
        $localRequest = $request->input();
        $keys = array_keys($localRequest);
        foreach ($keys as $key) {
            if (str_contains($key, 'checkbox')) {
                $checkbox_key = $key;
                break;
            }
        }
        $eventParticipant_ids = $localRequest[$checkbox_key];
        $progress_name = $request["update-progress"];
        foreach ($eventParticipant_ids as $eventParticipant_id) {
            $eventParticipant = EventParticipant::where('id', $eventParticipant_id)->first()->load(['participant', 'event.venue', 'fee']);
            switch ($progress_name) {
                case 'approve-application':
                    $update = EventParticipant::find($eventParticipant_id)->update([
                        'is_approved_application' => 1,
                        'approved_application_datetime' => Carbon::now(),
                    ]);
                    $message =  [
                        'opening' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . ($eventParticipant->participant->name),
                        'introduction' => 'Pendaftaran anda <b>TELAH DISAHKAN BERJAYA</b> oleh pihak INTEC bagi program, ',
                        'detail' => 'Program: ' . ($eventParticipant->event->name)
                            . '<br/>Tarikh: ' . ($eventParticipant->event->datetime_start) . ' sehingga ' . ($eventParticipant->event->datetime_end)
                            . '<br/>Tempat: ' . ($eventParticipant->event->venue->name)
                            . '<br/> <br/>Sila buat pembayaran yuran sebanyak <b>RM'
                            . ($eventParticipant->fee->amount) . ' (' . ($eventParticipant->fee->name)
                            . ')</b>, kemudian tekan butang di bawah untuk ke sesawang profil bagi mengemaskini status pembayaran untuk disahkan.',
                        'conclusion' => 'Kami amat menghargai segala usaha anda. Semoga urusan anda dipermudahkan. Terima kasih.',
                        'ic' => ($eventParticipant->participant->ic),
                    ];

                    Mail::send('short-course-management.email.email-payment-verified', $message, function ($message) use ($eventParticipant) {
                        $message->subject('Pengesahan Pendaftaran (Berjaya)');
                        $message->from(Auth::user()->email);
                        $message->to($eventParticipant->participant->email);
                    });
                    break;
                case 'reject-application':
                    $exist = EventParticipant::find($eventParticipant_id);
                    $exist->updated_by = Auth::user()->id;
                    $exist->deleted_by = Auth::user()->id;
                    $exist->save();
                    $exist->delete();

                    $message =  [
                        'opening' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . ($eventParticipant->participant->name),
                        'introduction' => 'Sebagai makluman, pendaftaran anda <b>TELAH DITOLAK</b> oleh pihak INTEC bagi program, ',
                        'detail' => 'Program: ' . ($eventParticipant->event->name)
                            . '<br/>Tarikh: ' . ($eventParticipant->event->datetime_start) . ' sehingga ' . ($eventParticipant->event->datetime_end)
                            . '<br/>Tempat: ' . ($eventParticipant->event->venue->name)
                            . '<br/> <br/>Jika ini adalah suatu kesilapan, sila hubungi pihak kami semula.',
                        'conclusion' => 'Kami amat menghargai segala usaha anda. Semoga urusan anda dipermudahkan. Terima kasih.',
                        'ic' => ($eventParticipant->participant->ic),
                    ];

                    Mail::send('short-course-management.email.email-payment-verified', $message, function ($message) use ($eventParticipant) {
                        $message->subject('Pengesahan Pendaftaran (Tidak Berjaya)');
                        $message->from(Auth::user()->email);
                        $message->to($eventParticipant->participant->email);
                    });
                    break;
                case 'disqualified-application-no-payment':
                    $update = EventParticipant::find($eventParticipant_id)->update([
                        'is_disqualified' => 1,
                        'disqualified_datetime' => Carbon::now(),
                    ]);

                    $message =  [
                        'opening' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . ($eventParticipant->participant->name),
                        'introduction' => 'Sebagai makluman, pendaftaran anda <b>TELAH DITOLAK</b> oleh pihak INTEC bagi program, ',
                        'detail' => 'Program: ' . ($eventParticipant->event->name)
                            . '<br/>Tarikh: ' . ($eventParticipant->event->datetime_start) . ' sehingga ' . ($eventParticipant->event->datetime_end)
                            . '<br/>Tempat: ' . ($eventParticipant->event->venue->name)
                            . '<br/> <br/>Jika ini adalah suatu kesilapan, sila hubungi pihak kami semula.',
                        'conclusion' => 'Kami amat menghargai segala usaha anda. Semoga urusan anda dipermudahkan. Terima kasih.',
                        'ic' => ($eventParticipant->participant->ic),
                    ];

                    Mail::send('short-course-management.email.email-payment-verified', $message, function ($message) use ($eventParticipant) {
                        $message->subject('Pengesahan Pendaftaran (Tidak Berjaya)');
                        $message->from(Auth::user()->email);
                        $message->to($eventParticipant->participant->email);
                    });
                    break;
                case 'verify-payment-proof':
                    $update = EventParticipant::find($eventParticipant_id)->update([
                        'is_verified_payment_proof' => 1,
                        'is_verified_approved_participation' => 1,
                        'approved_participation_datetime' => Carbon::now(),
                        'verified_payment_proof_datetime' => Carbon::now(),
                        'ic' => ($eventParticipant->participant->ic),
                    ]);

                    $message =  [
                        'opening' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . ($eventParticipant->participant->name),
                        'introduction' => 'Bukti pembayaran anda <b>TELAH DISAHKAN</b> oleh pihak INTEC bagi program, ',
                        'detail' => 'Program: ' . ($eventParticipant->event->name)
                            . '<br/>Tarikh: ' . ($eventParticipant->event->datetime_start) . ' sehingga ' . ($eventParticipant->event->datetime_end)
                            . '<br/>Tempat: ' . ($eventParticipant->event->venue->name),
                        'conclusion' => 'Kami amat menghargai segala usaha anda. Semoga urusan anda dipermudahkan. Terima kasih.',
                        'ic' => ($eventParticipant->participant->ic),
                    ];

                    Mail::send('short-course-management.email.email-payment-verified', $message, function ($message) use ($eventParticipant) {
                        $message->subject('Pengesahan Bukti Pembayaran (Disahkan Berjaya)');
                        $message->from(Auth::user()->email);
                        $message->to($eventParticipant->participant->email);
                    });
                    break;
                case 'reject-payment-proof':
                    $update = EventParticipant::find($eventParticipant_id)->update([
                        'is_verified_payment_proof' => null,
                        'verified_payment_proof_datetime' => null,
                    ]);

                    $message =  [
                        'opening' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . ($eventParticipant->participant->name),
                        'introduction' => 'Sebagai makluman, bukti pembayaran anda <b>TELAH DITOLAK</b> oleh pihak INTEC bagi program, ',
                        'detail' => 'Program: ' . ($eventParticipant->event->name)
                            . '<br/>Tarikh: ' . ($eventParticipant->event->datetime_start) . ' sehingga ' . ($eventParticipant->event->datetime_end)
                            . '<br/>Tempat: ' . ($eventParticipant->event->venue->name)
                            . '<br/> <br/>Sila buat pembayaran yuran sebanyak <b>RM'
                            . ($eventParticipant->fee->amount) . ' (' . ($eventParticipant->fee->name)
                            . ')</b>, kemudian tekan butang di bawah untuk ke sesawang profil bagi memasukkan bukti pembayaran yang baharu untuk disahkan.',
                        'conclusion' => 'Kami amat menghargai segala usaha anda. Semoga urusan anda dipermudahkan. Terima kasih.',
                        'ic' => ($eventParticipant->participant->ic),
                    ];

                    Mail::send('short-course-management.email.email-payment-verified', $message, function ($message) use ($eventParticipant) {
                        $message->subject('Pengesahan Pembayaran (Tidak Berjaya)');
                        $message->from(Auth::user()->email);
                        $message->to($eventParticipant->participant->email);
                    });
                    break;
                case 'verify-attendance-attend':
                    $update = EventParticipant::find($eventParticipant_id)->update([
                        'is_not_attend' => 0,
                        'is_question_sended' => 1,
                        'question_sended_datetime' => Carbon::now(),
                        'is_done_email_completed' => 0,
                    ]);
                    // $message =  [
                    //     'opening' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik '+ ($eventParticipant->participant->name),
                    //     'content' => 'Tahniah! Anda telah disahkan sebagai hadir bagi program ' + ($eventParticipant->event->name)
                    //     + ' yang dianjurkan oleh INTEC pada ' + ($eventParticipant->event->datetime_start) + ' sehingga '+ ($eventParticipant->event->datetime_end)
                    //     + ' di ' + ($eventParticipant->event->venue->name) +'. Kami amat menghargai segala usaha anda. Semoga anda terus berjaya. Terima kasih.',
                    // ];
                    // dd($eventParticipant);

                    $message =  [
                        'opening' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . ($eventParticipant->participant->name),
                        'introduction' => 'Tahniah! Anda telah disahkan sebagai <b>HADIR</b> bagi program, ',
                        'detail' => 'Program: ' . ($eventParticipant->event->name)
                            . '<br/>Tarikh: ' . ($eventParticipant->event->datetime_start) . ' sehingga ' . ($eventParticipant->event->datetime_end)
                            . '<br/>Tempat: ' . ($eventParticipant->event->venue->name),
                        'conclusion' => 'Kami amat menghargai segala usaha anda. Semoga anda terus berjaya. Terima kasih.',
                        'ic' => ($eventParticipant->participant->ic),
                        'event_participant_id' => ($eventParticipant->id),
                    ];

                    Mail::send('short-course-management.email.email-payment-verified', $message, function ($message) use ($eventParticipant) {
                        $message->subject('Pengesahan Kehadiran (Hadir)');
                        $message->from(Auth::user()->email);
                        $message->to($eventParticipant->participant->email);
                    });
                    break;
                case 'verify-attendance-not-attend':
                    $update = EventParticipant::find($eventParticipant_id)->update([
                        'is_not_attend' => 1,
                    ]);

                    $message =  [
                        'opening' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . ($eventParticipant->participant->name),
                        'introduction' => 'Anda telah disahkan sebagai <b>TIDAK HADIR</b> bagi program, ',
                        'detail' => 'Program: ' . ($eventParticipant->event->name)
                            . '<br/>Tarikh: ' . ($eventParticipant->event->datetime_start) . ' sehingga ' . ($eventParticipant->event->datetime_end)
                            . '<br/>Tempat: ' . ($eventParticipant->event->venue->name),
                        'conclusion' => 'Sila maklumkan kepada kami sekiranya ini adalah suatu kesilapan. Terima kasih.',
                        'ic' => ($eventParticipant->participant->ic),
                    ];

                    Mail::send('short-course-management.email.email-payment-verified', $message, function ($message) use ($eventParticipant) {
                        $message->subject('Pengesahan Kehadiran (Tidak Hadir)');
                        $message->from(Auth::user()->email);
                        $message->to($eventParticipant->participant->email);
                    });
                    break;
                case 'send-question':
                    $update = EventParticipant::find($eventParticipant_id)->update([
                        'is_question_sended' => 1,
                        'question_sended_datetime' => Carbon::now(),
                        'is_done_email_completed' => 0,
                    ]);
                    break;
                default:
                    break;
            }
        }
        $existEventParticipant = EventParticipant::find($eventParticipant_ids[0])->load(['event']);
        $event = $existEventParticipant->event;
        // return redirect("/event/' . $event->id . '/events-participants/show")->with( ['event' => $event] );
        return view('short-course-management.event-management.event-participant-show', compact('event'));
    }
    public function dataEventParticipantList($participant_id)
    {
        // $events = Event::orderByDesc('id')->get()->load(['events_participants', 'venue']);
        $eventsParticipants = EventParticipant::where('participant_id', $participant_id)->get()->load(['event', 'fee']);
        $events = [];
        $indexEvent = 0;
        foreach ($eventsParticipants as $eventParticipant) {
            // $event = Event::find($eventParticipant->event_id)->load(['events_participants', 'venue']);
            // array_push($events, $event);
            if ($eventParticipant->event) {
                array_push($events, $eventParticipant->event);
                $eventParticipant->event = null;
                $events[$indexEvent]['event_participant_id'] = $eventParticipant->id;
                $events[$indexEvent]['is_verified_payment_proof'] = $eventParticipant->is_verified_payment_proof;
                $events[$indexEvent]['payment_proof_path'] = $eventParticipant->payment_proof_path;
                $events[$indexEvent]['amount'] = $eventParticipant->fee->amount;
                $events[$indexEvent]['fee_name'] = $eventParticipant->fee->name;
                $events[$indexEvent]['is_question_sended'] = $eventParticipant->is_question_sended;
                $indexEvent += 1;
            }
        }
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

            $datetime_start = new DateTime($events[$index]->datetime_start);
            $datetime_end = new DateTime($events[$index]->datetime_end);
            $events[$index]['datetime_start_toDayDateTimeString'] = date_format($datetime_start, 'g:ia \o\n l jS F Y');
            $events[$index]['datetime_end_toDayDateTimeString'] = date_format($datetime_end, 'g:ia \o\n l jS F Y');
            $index++;
        }
        return datatables()::of($events)
            ->addColumn('dates', function ($events) {
                return 'Date Start: <br>' . $events->datetime_start_toDayDateTimeString . '<br><br> Date End: <br>' . $events->datetime_end_toDayDateTimeString;
            })
            ->addColumn('participant', function ($events) {
                return 'Total Valid: ' . $events->totalValidParticipants . '<br><br> Total Not Approved Yet: ' . $events->totalParticipantsNotApprovedYet . '<br><br> Total Reject: ' . $events->totalRejected;
            })
            ->addColumn('management_details', function ($events) {
                return 'Created By: ' . $events->created_by . '<br> Created At: ' . $events->created_at;
            })
            ->addColumn('fee_amount', function ($events) {
                return 'RM' . $events->amount . '/person (' . $events->fee_name . ')';
            })
            ->addColumn('action', function ($events) {
                if ($events->is_question_sended == 1) {
                    return '
                    <a href="#" data-target="#crud-modals" data-toggle="modal" data-event_id="' . $events->id . '" data-event_participant_id="' . $events->event_participant_id . '" data-is_verified_payment_proof="' . $events->is_verified_payment_proof . '" data-amount="' . $events->amount . '" class="btn btn-sm btn-primary">Update Payment Proof</a>
                    <a target="_blank" rel="noopener noreferrer"
                    href="/feedback/form/participant/'.$events->event_participant_id.'
                    type="submit" class="btn btn-sm btn-primary"
                    style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"; position: relative; -webkit-text-size-adjust: none; border-radius: 4px; color: #fff; display: inline-block; overflow: hidden; text-decoration: none; background-color: #2d3748; border-bottom: 8px solid #2d3748; border-left: 18px solid #2d3748; border-right: 18px solid #2d3748; border-top: 8px solid #2d3748;">Feedback
                    Form</a>';

                } else {
                    return '<a href="#" data-target="#crud-modals" data-toggle="modal" data-event_id="' . $events->id . '" data-event_participant_id="' . $events->event_participant_id . '" data-is_verified_payment_proof="' . $events->is_verified_payment_proof . '" data-amount="' . $events->amount . '" class="btn btn-sm btn-primary">Update Payment Proof</a>';
                }
            })

            // <a href="" data-target="#crud-modals" data-toggle="modal" data-id="' . $kolejs->id . '" data-name="' . $kolejs->name . '" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i> Sunting</a>
            // <button class="btn btn-sm btn-danger btn-delete" data-remote="/senarai_kolej/softDelete/' . $kolejs->id . '"><i class="fal fa-trash"></i>  Padam</button>
            ->rawColumns(['action', 'management_details', 'participant', 'dates'])
            ->make(true);
    }
    public function showPaymentProof($event_participant_id)
    {
        $eventParticipantPaymentProofs = EventParticipantPaymentProof::where([
            ['event_participant_id', '=', $event_participant_id]
        ])->get();

        $index = 0;
        foreach ($eventParticipantPaymentProofs as $eventParticipantPaymentProof) {
            $eventParticipantPaymentProofs[$index]['created_at_diffForHumans'] = $eventParticipantPaymentProof->created_at->diffForHumans();;
            $index += 1;
        }

        return $eventParticipantPaymentProofs;
    }
    public function removePaymentProof(Request $request, $payment_proof_id)
    {


        $exist = EventParticipantPaymentProof::find($payment_proof_id);
        if (Auth::user()->id) {
            $exist->updated_by = Auth::user()->id;
            $exist->deleted_by = Auth::user()->id;
        } else {
            $exist->updated_by = "public_user";
            $exist->deleted_by = "public_user";
        }
        $exist->save();
        $exist->delete();

        return Redirect()->back()->with('messageEventParticipantPaymentProof', 'A Payment Proof Deleted Successfully');
    }



    public function updatePaymentProof(Request $request)
    {
        if ($request->file('payment_proof_input')) {
            $date = Carbon::today()->toDateString();
            $year = substr($date, 0, 4);
            $month = substr($date, 5, 2);
            $day = substr($date, 8, 2);

            // $validated = $request->validate([
            //     'payment_proof_input' => 'required|mimes:jpg,jpeg,png',

            // ], [
            //     'payment_proof_input.required' => 'Poster is required',

            // ]);
            $posters = $request->file('payment_proof_input');

            foreach ($posters as $poster) {
                $name_gen = hexdec(uniqid());
                $img_ext = strtolower($poster->getClientOriginalExtension());

                $img_name = $year . $month . $day . '_id' . ($request->event_id) . '_' . $name_gen . '.' . $img_ext;



                $up_location = 'storage/shortcourse/payment_proof_input/' . $year . '/';
                $last_img = $up_location . $img_name;

                $poster->move($up_location, $img_name);
                // where('event_id', $request->event_id)->where('participant_id', $request->participant_id)
                EventParticipantPaymentProof::create([
                    'event_participant_id' => $request->event_participant_id,
                    'payment_proof_path' => $last_img,
                    'created_by' => 'public_user',
                ]);
            }

            $eventParticipantPaymentProof = EventParticipantPaymentProof::where([['event_participant_id', '=', $request->event_participant_id]])->get();
            $eventParticipant = EventParticipant::find($request->event_participant_id);
            if (count($eventParticipantPaymentProof) > 0 && $eventParticipant->is_verified_payment_proof != 1) {
                $update = EventParticipant::where([['id', '=', $request->event_participant_id]])->update([
                    'is_verified_payment_proof' => 0,
                    'updated_by' => 'public_user',
                    'updated_at' => Carbon::now()
                ]);
            }

            return Redirect()->back()->with('success', 'Payment proof updated successfully');
        }
        $eventParticipantPaymentProof = EventParticipantPaymentProof::where([['event_participant_id', '=', $request->event_participant_id]])->get();
        $eventParticipant = EventParticipant::find($request->event_participant_id);
        if (count($eventParticipantPaymentProof) > 0 && $eventParticipant->is_verified_payment_proof != 1) {
            $update = EventParticipant::where([['id', '=', $request->event_participant_id]])->update([
                'is_verified_payment_proof' => 0,
                'updated_by' => 'public_user',
                'updated_at' => Carbon::now()
            ]);
        }
        return Redirect()->back();
    }

    public function requestVerification($event_id, $participant_id)
    {
        $update = EventParticipant::where([['event_id', '=', $event_id], ['participant_id', '=', $participant_id]])->update([
            'is_verified_payment_proof' => 0,
            'updated_by' => 'public_user',
            'updated_at' => Carbon::now()
        ]);

        $update = EventParticipant::where([['event_id', '=', $event_id], ['participant_id', '=', $participant_id]])->first();
        return $update;
    }
}
