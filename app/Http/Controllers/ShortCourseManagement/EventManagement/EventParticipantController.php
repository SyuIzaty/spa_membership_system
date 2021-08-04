<?php

namespace App\Http\Controllers\ShortCourseManagement\EventManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShortCourseManagement\EventParticipant;
use App\Models\ShortCourseManagement\Event;
use App\Models\ShortCourseManagement\Participant;
use App\Models\ShortCourseManagement\Fee;
use Auth;
use DateTime;
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
                return '
                <a href="#" data-target="#crud-modals" data-toggle="modal" data-event_id="' . $eventsParticipants->event_id . '" data-participant_id="' . $eventsParticipants->participant_id . '" data-payment_proof_path="' . $eventsParticipants->payment_proof_path . '" data-is_verified_payment_proof="' . $eventsParticipants->is_verified_payment_proof . '" class="btn btn-sm btn-primary">Update Payment Proof</a>
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
                <a href="javascript:;" id="verify-payment-proof" data-remote="/update-progress/verify-payment-proof/' . $eventsParticipants->id . '" class="btn btn-sm btn-success btn-update-progress">Verify</a>
                <a href="javascript:;" id="reject-payment-proof" data-remote="/update-progress/reject-payment-proof/' . $eventsParticipants->id . '" class="btn btn-sm btn-danger btn-update-progress">Reject</a>';
            })
            ->rawColumns(['action', 'checkPaymentWaitForVerification'])
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
            ['is_not_attend', '=', null]
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
                return '<a href="javascript:;" id="verify-attendance-attend" data-remote="/update-progress/verify-attendance-attend/' . $eventsParticipants->id . '" class="btn btn-sm btn-success btn-update-progress">Attend</a>
                    <a href="javascript:;" id="verify-attendance-not-attend" data-remote="/update-progress/verify-attendance-not-attend/' . $eventsParticipants->id . '" class="btn btn-sm btn-danger btn-update-progress">Not Attend</a>';
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
            ['is_done_email_completed', '=', 1]
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
                'created_by' => Auth::user()->id,
            ]);
        } else {
            $existEventParticipant->fee_id = $request->fee_id;
            $existEventParticipant->updated_by = Auth::user()->id;
            $existEventParticipant->save();
            return Redirect()->back()->with('messageAlreadyApplied', 'The participant have already been applied before.');
        }
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

    public function updateProgress($progress_name, $eventsParticipants_id)
    {
        // if ($progress_name == 'approve-application') {
        //     $update = EventParticipant::find($eventsParticipants_id)->update([
        //         'is_approved_application' => 1,
        //         'approved_application_datetime' => Carbon::now(),
        //     ]);
        // }else if ($progress_name == 'reject-application'
        // || $progress_name == 'disqualified-application-no-payment') {
        //     $update = EventParticipant::find($eventsParticipants_id)->update([
        //         'is_disqualified' => 1,
        //         'disqualified_datetime' => Carbon::now(),
        //     ]);
        // }else if ($progress_name == 'verify-payment-proof') {
        //     $update = EventParticipant::find($eventsParticipants_id)->update([
        //         'is_verified_payment_proof' => 1,
        //         'is_verified_approved_participation' => 1,
        //         'approved_participation_datetime' => Carbon::now(),
        //         'verified_payment_proof_datetime' => Carbon::now(),
        //     ]);
        // }else if ($progress_name == 'reject-payment-proof') {
        //     $update = EventParticipant::find($eventsParticipants_id)->update([
        //         'is_verified_payment_proof' => null,
        //         'verified_payment_proof_datetime' => null,
        //     ]);
        // }else if ($progress_name == 'verify-attendance-attend') {
        //     $update = EventParticipant::find($eventsParticipants_id)->update([
        //         'is_not_attend' => 0,
        //     ]);
        // }else if ($progress_name == 'verify-attendance-not-attend') {
        //     $update = EventParticipant::find($eventsParticipants_id)->update([
        //         'is_not_attend' => 1,
        //     ]);
        // }else if ($progress_name == 'send-question') {
        //     $update = EventParticipant::find($eventsParticipants_id)->update([
        //         'is_question_sended' => 1,
        //         'question_sended_datetime' => Carbon::now(),
        //         'is_done_email_completed' => 0,
        //     ]);
        // }
        switch ($progress_name) {
            case 'approve-application':
                $update = EventParticipant::find($eventsParticipants_id)->update([
                    'is_approved_application' => 1,
                    'approved_application_datetime' => Carbon::now(),
                ]);
                break;
            case 'reject-application':
                $exist = EventParticipant::find($eventsParticipants_id);
                $exist->updated_by = Auth::user()->id;
                $exist->deleted_by = Auth::user()->id;
                $exist->save();
                $exist->delete();
                break;
            case 'disqualified-application-no-payment':
                $update = EventParticipant::find($eventsParticipants_id)->update([
                    'is_disqualified' => 1,
                    'disqualified_datetime' => Carbon::now(),
                ]);
                break;
            case 'verify-payment-proof':
                $update = EventParticipant::find($eventsParticipants_id)->update([
                    'is_verified_payment_proof' => 1,
                    'is_verified_approved_participation' => 1,
                    'approved_participation_datetime' => Carbon::now(),
                    'verified_payment_proof_datetime' => Carbon::now(),
                ]);
                break;
            case 'reject-payment-proof':
                $update = EventParticipant::find($eventsParticipants_id)->update([
                    'is_verified_payment_proof' => null,
                    'verified_payment_proof_datetime' => null,
                ]);
                break;
            case 'verify-attendance-attend':
                $update = EventParticipant::find($eventsParticipants_id)->update([
                    'is_not_attend' => 0,
                ]);
                break;
            case 'verify-attendance-not-attend':
                $update = EventParticipant::find($eventsParticipants_id)->update([
                    'is_not_attend' => 1,
                ]);
                break;
            case 'send-question':
                $update = EventParticipant::find($eventsParticipants_id)->update([
                    'is_question_sended' => 1,
                    'question_sended_datetime' => Carbon::now(),
                    'is_done_email_completed' => 0,
                ]);
                break;
            default:
                break;
        }
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
            if($eventParticipant->event){
                array_push($events, $eventParticipant->event);
                $eventParticipant->event = null;
                $events[$indexEvent]['is_verified_payment_proof'] = $eventParticipant->is_verified_payment_proof;
                $events[$indexEvent]['payment_proof_path'] = $eventParticipant->payment_proof_path;
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
                return 'Total Valid: ' . $events->totalValidParticipants . '<br> Total Not Approved Yet:' . $events->totalParticipantsNotApprovedYet . '<br> Total Reject:' . $events->totalRejected;
            })
            ->addColumn('management_details', function ($events) {
                return 'Created By: ' . $events->created_by . '<br> Created At: ' . $events->created_at;
            })
            ->addColumn('action', function ($events) {
                return '
                <a href="#" data-target="#crud-modals" data-toggle="modal" data-event_id="' . $events->id . '" data-payment_proof_path="' . $events->payment_proof_path . '" data-is_verified_payment_proof="' . $events->is_verified_payment_proof . '" class="btn btn-sm btn-primary">Update Payment Proof</a>
                <a href="#" class="btn btn-sm btn-danger">Cancel Application</a>';
            })

            // <a href="" data-target="#crud-modals" data-toggle="modal" data-id="' . $kolejs->id . '" data-name="' . $kolejs->name . '" class="btn btn-sm btn-warning"><i class="fal fa-pencil"></i> Sunting</a>
            // <button class="btn btn-sm btn-danger btn-delete" data-remote="/senarai_kolej/softDelete/' . $kolejs->id . '"><i class="fal fa-trash"></i>  Padam</button>
            ->rawColumns(['action', 'management_details', 'participant', 'dates'])
            ->make(true);
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
            $poster = $request->file('payment_proof_input');

            $name_gen = hexdec(uniqid());
            $img_ext = strtolower($poster->getClientOriginalExtension());

            $img_name = $year . $month . $day . '_id' . ($request->event_id) . '_' . $name_gen . '.' . $img_ext;

            /* utk file upload, create folder shortcourse under storage/app.
            so semua file upload berkaitan sistem shortcourse akan ada dalam storage/app/shortcourse.
            kat dalam folder tu terpulang lah mcm mana nak susun.ikut kesesuaian data.
            normally kalau data mcm shortcourse ni sy buat subfolder tahun/courseid */


            $up_location = 'storage/shortcourse/payment_proof_input/' . $year . '/';
            $last_img = $up_location . $img_name;

            $poster->move($up_location, $img_name);
            // where('event_id', $request->event_id)->where('participant_id', $request->participant_id)
            EventParticipant::where([['event_id', '=', $request->event_id], ['participant_id', '=', $request->participant_id]])->update([
                'payment_proof_path' => $last_img,
                'updated_by' => 'public_user',
                'updated_at' => Carbon::now()
            ]);

            return Redirect()->back()->with('success', 'Payment proof updated successfully');
        }
        return Redirect()->back();
    }

    public function requestVerification($event_id, $participant_id)
    {
        // dd('Event_id:'.$event_id.',Participant_id:'.$participant_id);
        $update=EventParticipant::where([['event_id', '=', $event_id], ['participant_id', '=', $participant_id]])->update([
            'is_verified_payment_proof' => 0,
            'updated_by' => 'public_user',
            'updated_at' => Carbon::now()
        ]);

        $update=EventParticipant::where([['event_id', '=', $event_id], ['participant_id', '=', $participant_id]])->first();
        return $update;
    }
}
