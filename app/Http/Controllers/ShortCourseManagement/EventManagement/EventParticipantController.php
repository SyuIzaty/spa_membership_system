<?php

namespace App\Http\Controllers\ShortCourseManagement\EventManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShortCourseManagement\EventParticipant;
use App\Models\ShortCourseManagement\Event;
use App\Models\ShortCourseManagement\Participant;
use App\Models\ShortCourseManagement\Fee;
use App\Models\ShortCourseManagement\EventParticipantPaymentProof;
use App\Models\ShortCourseManagement\EventModuleEventParticipant;
use Barryvdh\DomPDF\Facade as PDF;
use Auth;
use DateTime;
use File;
use Response;

use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class EventParticipantController extends Controller
{
    public function show($id)
    {
        $event = Event::find($id)->load(['events_participants', 'events_shortcourses.shortcourse.event_modules']);

        $currentApplicants = $event->events_participants
            ->where('is_approved_application', 1)->where('is_disqualified', '!=', 1)
            ->count();

        $event->total_seat_available = $event->max_participant - $currentApplicants;

        return view('short-course-management.event-management.event-participant-show', compact('event'));
    }
    public function dataAllApplicant($id)
    {
        $eventsParticipants = EventParticipant::where([
            ['event_id', '=', $id],
        ])->get()
            ->load([
                'event',
                'organization_representative',
                'participant.organisations_participants.organisation',
                'event_modules_event_participants.event_module'
            ]);

        $index = 0;
        foreach ($eventsParticipants as $eventParticipant) {
            $eventsParticipants[$index]->created_at_diffForHumans = $eventsParticipants[$index]->created_at->diffForHumans();
            $eventsParticipants[$index]->organisationsString = '';
            foreach ($eventParticipant->participant->organisations_participants as $organisation_participant) {
                $eventsParticipants[$index]->organisationsString = ($eventsParticipants[$index]->organisationsString) . ($organisation_participant->organisation->name) . '<br/>';
            }

            $eventsParticipants[$index]->selected_module = '';
            $moduleIndex = 1;
            foreach ($eventParticipant->event_modules_event_participants as $event_module_event_participant) {
                $eventsParticipants[$index]->selected_modules = ($eventsParticipants[$index]->selected_modules) . $moduleIndex . ') ' . ($event_module_event_participant->event_module->name) . '<br/>';
                $moduleIndex++;
            }

            //current status
            if ($eventParticipant->is_disqualified == 1) {
                $eventsParticipants[$index]->currentStatus = 'Disqualified';
            } else if ($eventParticipant->is_done_email_completed == 1) {
                $eventsParticipants[$index]->currentStatus = 'Feedback Status (Done)';
            } else if ($eventParticipant->is_done_email_completed == 0 && $eventParticipant->is_question_sended == 1) {
                $eventsParticipants[$index]->currentStatus = 'Feedback Status (Not Done Yet)';
            } else if ($eventParticipant->is_question_sended == 0 && $eventParticipant->is_not_attend == 1) {
                $eventsParticipants[$index]->currentStatus = 'Attendance Status (Not Attend)';
            } else if ($eventParticipant->is_question_sended == 0 && ($eventParticipant->is_not_attend == 0 && !is_null($eventParticipant->is_not_attend))) {
                $eventsParticipants[$index]->currentStatus = 'Attendance Status (Attend)';
            } else if ($eventParticipant->is_not_attend == null && $eventParticipant->is_verified_payment_proof == 1) {
                $eventsParticipants[$index]->currentStatus = 'Payment Status - Verification (Done)';
            } else if ($eventParticipant->is_not_attend == null && is_null($eventParticipant->is_verified_payment_proof)) {
                $eventsParticipants[$index]->currentStatus = 'Payment Status - Verification (Rejected)';
            } else if (($eventParticipant->is_verified_payment_proof == 0 && !is_null($eventParticipant->is_verified_payment_proof)) && $eventParticipant->is_approved_application == 1) {
                $eventsParticipants[$index]->currentStatus = 'Payment Status - Verification (Request for Verification)';
            } else {
                $eventsParticipants[$index]->currentStatus = 'N/A';
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
                if ($eventsParticipants->is_disqualified == 1) {
                    return '
                    <div class="d-flex justify-content-between flex-row">
                        <a href="javascript:;" id="restore-application" data-remote="/update-progress/restore-application/' . $eventsParticipants->id . '" class="btn btn-sm btn-success btn-update-progress mx-2">Restore</a>
                        <a href="javascript:;" id="delete-application" data-remote="/update-progress/delete-application/' . $eventsParticipants->id . '" class="btn btn-sm btn-danger btn-update-progress mx-2">Delete</a>
                    </div>';
                } else if ($eventsParticipants->is_done_email_completed == 1) {
                    return '
                    <div class="d-flex justify-content-between flex-row">
                        <a href="/event-participant/print-certificate/' . $eventsParticipants->id . '" id="generate-certificate" data-event_participant_id="' . $eventsParticipants->id . '" class="btn btn-sm btn-primary mx-2">Certificate</a>
                        <a href="javascript:;" id="edit-application" data-toggle="modal" data-event_participant_id="' . $eventsParticipants->id . '" data-participant_ic="' . $eventsParticipants->participant->ic . '" class="btn btn-sm btn-success btn-edit-application mx-2">Edit</a>
                    </div>';
                }
                // return '<a href="javascript:;" id="edit-application" data-toggle="modal" data-event_participant_id="' . $eventsParticipants->id . '" data-participant_ic="' . $eventsParticipants->participant->ic . '" class="btn btn-sm btn-success btn-edit-application">Edit</a>';
                return '
                <div class="d-flex justify-content-between flex-row">
                    <a href="/event-participant/print-certificate/' . $eventsParticipants->id . '" id="generate-certificate" data-event_participant_id="' . $eventsParticipants->id . '" class="btn btn-sm btn-primary mx-2">Certificate</a>
                    <a href="javascript:;" id="edit-application" data-toggle="modal" data-event_participant_id="' . $eventsParticipants->id . '" data-participant_ic="' . $eventsParticipants->participant->ic . '" class="btn btn-sm btn-success btn-edit-application mx-2">Edit</a>
                </div>';
            })
            ->rawColumns(['action', 'checkApplicant', 'selected_modules', 'currentStatus'])
            ->make(true);
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
            $eventsParticipants[$index]->created_at_diffForHumans = $eventsParticipants[$index]->created_at->diffForHumans();
            $eventsParticipants[$index]->organisationsString = '';
            foreach ($eventParticipant->participant->organisations_participants as $organisation_participant) {
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
            $eventsParticipants[$index]->created_at_diffForHumans = $eventsParticipants[$index]->created_at->diffForHumans();
            $eventsParticipants[$index]->organisationsString = '';
            foreach ($eventParticipant->participant->organisations_participants as $organisation_participant) {
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
            $eventsParticipants[$index]->created_at_diffForHumans = $eventsParticipants[$index]->created_at->diffForHumans();
            $eventsParticipants[$index]->organisationsString = '';
            foreach ($eventParticipant->participant->organisations_participants as $organisation_participant) {
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
            $eventsParticipants[$index]->created_at_diffForHumans = $eventsParticipants[$index]->created_at->diffForHumans();
            $eventsParticipants[$index]->organisationsString = '';
            foreach ($eventParticipant->participant->organisations_participants as $organisation_participant) {
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
            $eventsParticipants[$index]->created_at_diffForHumans = $eventsParticipants[$index]->created_at->diffForHumans();
            $eventsParticipants[$index]->organisationsString = '';
            foreach ($eventParticipant->participant->organisations_participants as $organisation_participant) {
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
        ])->get()
            ->load([
                'event',
                'organization_representative',
                'participant.organisations_participants.organisation'
            ]);

        $index = 0;
        foreach ($eventsParticipants as $eventParticipant) {
            $eventsParticipants[$index]->created_at_diffForHumans = $eventsParticipants[$index]->created_at->diffForHumans();
            $eventsParticipants[$index]->organisationsString = '';
            foreach ($eventParticipant->participant->organisations_participants as $organisation_participant) {
                $eventsParticipants[$index]->organisationsString = ($eventsParticipants[$index]->organisationsString) .
                    ($organisation_participant->organisation->name) .
                    '.';
            }
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
                $buttonString = '';

                if (is_null($eventsParticipants->is_not_attend)) {
                    $buttonString .= '<a href="javascript:;" id="verify-attendance-attend" data-remote="/update-progress/verify-attendance-attend/' . $eventsParticipants->id . '" class="btn btn-sm btn-success btn-update-progress">Attend</a>
                        <a href="javascript:;" id="verify-attendance-not-attend" data-remote="/update-progress/verify-attendance-not-attend/' . $eventsParticipants->id . '" class="btn btn-sm btn-danger btn-update-progress">Not Attend</a>';
                } else if ($eventsParticipants->is_not_attend === 0) {
                    $buttonString .= '<a href="javascript:;" id="verify-attendance-not-attend" data-remote="/update-progress/verify-attendance-not-attend/' . $eventsParticipants->id . '" class="btn btn-sm btn-danger btn-update-progress">Not Attend</a>';
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
            $eventsParticipants[$index]->created_at_diffForHumans = $eventsParticipants[$index]->created_at->diffForHumans();
            $eventsParticipants[$index]->organisationsString = '';
            foreach ($eventParticipant->participant->organisations_participants as $organisation_participant) {
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
            $eventsParticipants[$index]->created_at_diffForHumans = $eventsParticipants[$index]->created_at->diffForHumans();
            $eventsParticipants[$index]->organisationsString = '';
            foreach ($eventParticipant->participant->organisations_participants as $organisation_participant) {
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
            $eventsParticipants[$index]->created_at_diffForHumans = $eventsParticipants[$index]->created_at->diffForHumans();
            $eventsParticipants[$index]->organisationsString = '';
            foreach ($eventParticipant->participant->organisations_participants as $organisation_participant) {
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
        ])->get()
            ->load([
                'event',
                'organization_representative',
                'participant.organisations_participants.organisation'
            ]);

        $index = 0;
        foreach ($eventsParticipants as $eventParticipant) {
            $eventsParticipants[$index]->created_at_diffForHumans = $eventsParticipants[$index]->created_at->diffForHumans();
            $eventsParticipants[$index]->organisationsString = '';
            if ($eventsParticipants[$index]->is_done_email_completed == 1) {
                $eventsParticipants[$index]->done_email_completed_datetime_diffForHumans = $eventsParticipants[$index]->done_email_completed_datetime;
            } else {
                $eventsParticipants[$index]->done_email_completed_datetime_diffForHumans = $eventsParticipants[$index]->done_email_completed_datetime;
            }
            foreach ($eventParticipant->participant->organisations_participants as $organisation_participant) {
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
            $eventsParticipants[$index]->created_at_diffForHumans = $eventsParticipants[$index]->created_at->diffForHumans();
            $eventsParticipants[$index]->organisationsString = '';
            foreach ($eventParticipant->participant->organisations_participants as $organisation_participant) {
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
    }

    public function store(Request $request, $event_id)
    {
        if ($request->input_type == 'add') {

            $validated = $request->validate([
                'ic_input' => 'required',
                'firstname' => 'required|min:2',
                'lastname' => 'required|min:2',
                'fullname' => 'required|min:3',
                'gender' => 'required',
                'phone' => 'required|min:10',
                'email' => 'required|email:rfc',
                'fee_id' => 'required',
                'representative_ic_input'  => 'required',
                'representative_fullname' => 'required',
                'payment_proof_input' => 'present|array',

            ], [
                'ic_input.required' => 'Please insert IC of the participant',
                'firstname.required' => 'Please insert firstname of the participant',
                'lastname.required' => 'Please insert lastname of the participant',
                'fullname.required' => 'Please insert fullname of the participant',
                'firstname.min' => 'The firstname should have at least 2 characters',
                'lastname.min' => 'The lastname should have at least 2 characters',
                'fullname.min' => 'The fullname should have at least 3 characters',
                'gender.required' => 'Please insert gender of the participant',
                'phone.required' => 'Please insert phone number of the participant',
                'phone.min' => 'The phone number should have at least 10 characters',
                'email.required' => "Please insert email address of the participant",
                'fee_id.required' => 'Please choose the fee applicable for the participant',
                'representative_fullname.required' => 'Please insert the representative fullname of the participant',
                'representative_ic_input.required' => "Please insert the representative's IC of the participant",
                'representative_fullname.min' => "The representative's fullname should have at least 3 characters",
                'payment_proof_input.present' => "At least one payment proof is required",
            ]);
        } else {

            $validated = $request->validate([
                'ic_input' => 'required',
                'firstname' => 'required|min:2',
                'lastname' => 'required|min:2',
                'fullname' => 'required|min:3',
                'gender' => 'required',
                'phone' => 'required|min:10',
                'email' => 'required|email:rfc',
                'fee_id' => 'required',
                'representative_ic_input'  => 'required',
                'representative_fullname' => 'required',

            ], [
                'ic_input.required' => 'Please insert IC of the participant',
                'firstname.required' => 'Please insert firstname of the participant',
                'lastname.required' => 'Please insert lastname of the participant',
                'fullname.required' => 'Please insert fullname of the participant',
                'firstname.min' => 'The firstname should have at least 2 characters',
                'lastname.min' => 'The lastname should have at least 2 characters',
                'fullname.min' => 'The fullname should have at least 3 characters',
                'gender.required' => 'Please insert gender of the participant',
                'phone.required' => 'Please insert phone number of the participant',
                'phone.min' => 'The phone number should have at least 10 characters',
                'email.required' => "Please insert email address of the participant",
                'fee_id.required' => 'Please choose the fee applicable for the participant',
                'representative_fullname.required' => 'Please insert the representative fullname of the participant',
                'representative_ic_input.required' => "Please insert the representative's IC of the participant",
                'representative_fullname.min' => "The representative's fullname should have at least 3 characters",
            ]);
        }
        if ($request->is_modular == 1 && !$request->modules) {
            return Redirect()->back()->with('failedNewApplication', 'New Application Failed. At least a module should be selected for Modular Short Course. Please try again.');
        }
        $min_module = (int)($request->modular_num_of_selection_min);
        $max_module = (int)($request->modular_num_of_selection_max);

        if ($request->is_modular == 1 && $request->is_modular_single_selection == 0 && (count($request->modules) < $min_module || count($request->modules) > $max_module)) {
            return Redirect()->back()->with('failedNewApplication', 'New Application Failed. The module selection must be in the range of ' . ($request->modular_num_of_selection_min) . ' to ' . ($request->modular_num_of_selection_max));
        }
        if (($request->input_type == 'add' && $request->file('payment_proof_input')) || $request->input_type == 'edit') {
            $existParticipant = Participant::where([
                ['ic', '=', $request->ic_input],
            ])->first();
            if (!$existParticipant) {
                $sha1_ic = sha1($request->ic_input);
                $existParticipant = Participant::create([
                    'name' => $request->fullname,
                    'first_name' => $request->firstname,
                    'last_name' => $request->lastname,
                    'ic' => $request->ic_input,
                    'sha1_ic' => $sha1_ic,
                    'gender' => $request->gender,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'created_by' => Auth::user() ? Auth::user()->id : 'public_user',
                ]);
            } else {
                $sha1_ic = sha1($request->ic_input);
                $existParticipant->name = $request->fullname;
                $existParticipant->first_name = $request->firstname;
                $existParticipant->last_name = $request->lastname;
                $existParticipant->ic = $request->ic_input;
                $existParticipant->sha1_ic = $sha1_ic;
                $existParticipant->gender = $request->gender;
                $existParticipant->phone = $request->phone;
                $existParticipant->email = $request->email;
                $existParticipant->updated_by = Auth::user() ? Auth::user()->id : 'public_user';
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
                    'fee_amount_applied' => $request->fee_amount_applied_total,
                    'participant_representative_id' => $existParticipant->id,
                    'is_verified_payment_proof' => 0,
                    'is_approved_application' => 1,
                    'created_by' => Auth::user() ? Auth::user()->id : 'public_user',
                ]);
            } else {
                $existEventParticipant->fee_id = $request->fee_id;
                $existEventParticipant->fee_amount_applied = $request->fee_amount_applied_total;
                $existEventParticipant->updated_by = Auth::user() ? Auth::user()->id : 'public_user';
                $existEventParticipant->save();
                if ($request->input_type == 'add') {
                    return Redirect()->back()->with('messageAlreadyApplied', 'The participant have already been applied before.');
                }
            }


            $existEvent = Event::where('id', $event_id)->first()->load(['venue']);
            $existFee = Fee::where('id', $request->fee_id)->first();

            // Start payment proof
            if ($request->input_type == 'add') {


                $date = Carbon::today()->toDateString();
                $year = substr($date, 0, 4);
                $month = substr($date, 5, 2);
                $day = substr($date, 8, 2);
                $images = $request->file('payment_proof_input');

                foreach ($images as $image) {

                    // Public Folder
                    // $name_gen = hexdec(uniqid());
                    // $img_ext = strtolower($image->getClientOriginalExtension());

                    // $img_name = $year . $month . $day . '_id' . ($request->event_id) . '_' . $name_gen . '.' . $img_ext;



                    // $up_location = 'storage/shortcourse/payment_proof_input/' . $year . '/';
                    // $last_img = $up_location . $img_name;

                    // $image->move($up_location, $img_name);
                    // End of Public


                    $name_gen = hexdec(uniqid());
                    $img_ext = strtolower($image->getClientOriginalExtension());

                    $img_name = $year . $month . $day . '_id' . ($request->event_id) . '_' . $name_gen . '.' . $img_ext;

                    $up_location = 'shortcourse/payment_proof_input/' . $year . '/';

                    $image->storeAs($up_location, $img_name);
                    $web_path = "app/" . $up_location . $img_name;
                    $request->merge(['upload_image' => $img_name, 'web_path' => $web_path]);


                    EventParticipantPaymentProof::create([
                        'event_participant_id' => $existEventParticipant->id,
                        'name' => $img_name,
                        'payment_proof_path' => "app/" . $up_location,
                        'created_by' => Auth::user() ? Auth::user()->id : 'public_user',
                    ]);
                }


                $eventParticipantPaymentProof = EventParticipantPaymentProof::where([['event_participant_id', '=', $existEventParticipant->id]])->get();
                $eventParticipant = EventParticipant::find($existEventParticipant->id);
                if (count($eventParticipantPaymentProof) > 0 && $eventParticipant->is_verified_payment_proof != 1) {
                    $update = EventParticipant::where([['id', '=', $request->event_participant_id]])->update([
                        'is_verified_payment_proof' => 0,
                        'updated_by' => Auth::user() ? Auth::user()->id : 'public_user',
                        'updated_at' => Carbon::now()
                    ]);
                }
            }
            // End payment proof

            // if ($request->is_modular == 1) {
            //     foreach ($request->modules as $module) {
            //         $participantModule = EventModuleEventParticipant::where([['event_module_id', '=', $module], ['event_participant_id', '=', $existEventParticipant->id]])->first();
            //         if (!$participantModule) {
            //             EventModuleEventParticipant::create([
            //                 'event_module_id' => $module,
            //                 'event_participant_id' => $existEventParticipant->id,
            //                 'created_by' => Auth::user() ? Auth::user()->id : 'public_user',
            //             ]);
            //         }
            //     }
            // }
            if ($request->is_modular == 1) {
                $participantModuleAll = EventModuleEventParticipant::where([['event_participant_id', '=', $existEventParticipant->id]])->get();
                // dd($participantModuleAll);
                foreach ($request->modules as $module) {
                    $moduleExist = false;
                    foreach ($participantModuleAll as $participantModule) {
                        if ($module == $participantModule->event_module_id) {
                            $moduleExist = true;
                            break;
                        }
                    }
                    if ($moduleExist == false) {
                        EventModuleEventParticipant::create([
                            'event_module_id' => $module,
                            'event_participant_id' => $existEventParticipant->id,
                            'created_by' => Auth::user() ? Auth::user()->id : 'public_user',
                        ]);
                    }
                }
                foreach ($participantModuleAll as $participantModule) {
                    $moduleNotExist = false;
                    foreach ($request->modules as $module) {
                        if ($module == $participantModule->event_module_id) {
                            $moduleNotExist = true;
                            break;
                        }
                    }
                    if ($moduleNotExist == false) {
                        $participantModule->updated_by = Auth::user()->id;
                        $participantModule->deleted_by = Auth::user()->id;
                        $participantModule->save();
                        $participantModule->delete();
                    }
                }
            }


            if ($request->input_type == 'add') {
                $message =  [
                    'opening' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . ($existParticipant->name),
                    'introduction' => 'Pendaftaran anda <b>TELAH DISAHKAN BERJAYA</b> oleh pihak INTEC bagi program, ',
                    'detail' => 'Program: ' . ($existEvent->name)
                        . '<br/>Tarikh: ' . ($existEvent->datetime_start) . ' sehingga ' . ($existEvent->datetime_end)
                        . '<br/>Tempat: ' . ($existEvent->venue->name)
                        . '<br/> <br/>Sila buat pembayaran yuran sebanyak <b>RM'
                        . ($existEventParticipant->fee_amount_applied) . ' (' . ($existFee->name)
                        . ')</b>, kemudian tekan butang di bawah untuk ke sesawang profil bagi mengemaskini status pembayaran untuk disahkan.',
                    'conclusion' => 'Kami amat menghargai segala usaha anda. Semoga urusan anda dipermudahkan. Terima kasih.',
                    'sha1_ic' => ($existParticipant->sha1_ic),
                ];

                Mail::send('short-course-management.email.email-payment-verified', $message, function ($message) use ($request) {
                    $message->subject('Pengesahan Pendaftaran (Berjaya)');
                    $message->from(Auth::user() ? Auth::user()->email : 'corporate@intec.edu.my');
                    $message->to($request->email);
                });

                $message =  [
                    'opening' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . ($existParticipant->name),
                    'introduction' => 'Bukti pembayaran anda <b>TELAH DIHANTAR dan SEDANG DISEMAK</b> oleh pihak INTEC bagi program, ',
                    'detail' => 'Program: ' . ($existEvent->name)
                        . '<br/>Tarikh: ' . ($existEvent->datetime_start) . ' sehingga ' . ($existEvent->datetime_end)
                        . '<br/>Tempat: ' . ($existEvent->venue->name),
                    'conclusion' => 'Sila tunggu maklumbalas dari kami bagi pengesahan pembayaran anda.
                Sebarang pertanyaan boleh terus berhubung dengan kami.
                Kami amat menghargai segala usaha anda. Semoga urusan anda dipermudahkan. Terima kasih.',
                    'sha1_ic' => ($eventParticipant->participant->sha1_ic),
                ];

                Mail::send('short-course-management.email.email-payment-verified', $message, function ($message) use ($request) {
                    $message->subject('Pengesahan Bukti Pembayaran (Telah Dihantar dan Sedang Disemak)');
                    $message->from(Auth::user() ? Auth::user()->email : 'corporate@intec.edu.my');
                    $message->to($request->email);
                });

                return Redirect()->back()->with('successNewApplication', 'New Application Created successfully');
            } else {

                return Redirect()->back()->with('successUpdateApplication', 'Application updated successfully');
            }
        } else {
            return Redirect()->back()->with('failedNewApplication', 'New Application Failed. Please try again.');
        }
    }
    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }

    public function applyPromoCode($event_id, $promo_code)
    {
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
        $this->_progressFlow($eventParticipant_id, $progress_name);
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
            $this->_progressFlow($eventParticipant_id, $progress_name);
        }
        $existEventParticipant = EventParticipant::find($eventParticipant_ids[0])->load(['event']);
        $event = $existEventParticipant->event;
        // return view('short-course-management.event-management.event-participant-show', compact('event'));
        // return redirect()->route('Merchant view')->with( ['event' => $event] );
        return redirect()->back()->with(compact('event'));
    }
    public function dataEventParticipantList($participant_id)
    {
        $eventsParticipants = EventParticipant::where('participant_id', $participant_id)->get()->load(['event', 'fee', 'participant']);
        $events = [];
        $indexEvent = 0;
        foreach ($eventsParticipants as $eventParticipant) {
            if ($eventParticipant->event) {
                array_push($events, $eventParticipant->event);
                $eventParticipant->event = null;
                $events[$indexEvent]['event_participant_id'] = $eventParticipant->id;
                $events[$indexEvent]['is_verified_payment_proof'] = $eventParticipant->is_verified_payment_proof;
                $events[$indexEvent]['payment_proof_path'] = $eventParticipant->payment_proof_path;
                $events[$indexEvent]['amount'] = $eventParticipant->fee->amount;
                $events[$indexEvent]['fee_name'] = $eventParticipant->fee->name;
                $events[$indexEvent]['is_question_sended'] = $eventParticipant->is_question_sended;
                $events[$indexEvent]['participant_sha1_ic'] = $eventParticipant->participant->sha1_ic;
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
            $events[$index]['datetime_start_toDayDateTimeString'] = date_format($datetime_start, 'j/m/Y \(l\) g:ia');
            $events[$index]['datetime_end_toDayDateTimeString'] = date_format($datetime_end, 'j/m/Y \(l\) g:ia');
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
                if ($events->is_verified_payment_proof == 1) {
                    return '
                    <div class="d-flex justify-content-center">
                        <a href="#" data-target="#crud-modals" data-toggle="modal" data-event_id="' . $events->id . '" data-event_participant_id="' . $events->event_participant_id . '" data-is_verified_payment_proof="' . $events->is_verified_payment_proof . '" data-amount="' . $events->amount . '" class="btn btn-sm btn-primary">Update Payment Proof</a>
                        <a target="_blank" rel="noopener noreferrer"
                        href="/feedback/form/participant/' . $events->event_participant_id . '/' . $events->participant_sha1_ic . '"
                        type="submit" class="btn btn-sm btn-primary"
                        style="margin-left:5px; box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"; position: relative; -webkit-text-size-adjust: none; border-radius: 4px; color: #fff; display: inline-block; overflow: hidden; text-decoration: none; background-color: #2d3748; border-bottom: 8px solid #2d3748; border-left: 18px solid #2d3748; border-right: 18px solid #2d3748; border-top: 8px solid #2d3748;">Feedback
                        Form</a>
                    </div>';
                } else {
                    return '<a href="#" data-target="#crud-modals" data-toggle="modal" data-event_id="' . $events->id . '" data-event_participant_id="' . $events->event_participant_id . '" data-is_verified_payment_proof="' . $events->is_verified_payment_proof . '" data-amount="' . $events->amount . '" class="btn btn-sm btn-primary">Update Payment Proof</a>';
                }
            })
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
            $eventParticipantPaymentProofs[$index]['created_at_diffForHumans'] = $eventParticipantPaymentProof->created_at->diffForHumans();

            $index += 1;
        }

        return $eventParticipantPaymentProofs;
    }

    public function getPaymentProofImage($id, $payment_proof_path)
    {
        $event_participant_payment_proof = EventParticipantPaymentProof::find($id);
        $path = storage_path() . '/' . $event_participant_payment_proof->payment_proof_path . $payment_proof_path;

        $file = File::get($path);
        $filetype = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $filetype);

        return $response;
    }

    public function removePaymentProof(Request $request)
    {

        $exist = EventParticipantPaymentProof::find($request->payment_proof_id);
        $existEventParticipant = EventParticipant::find($exist->event_participant_id)->load(['participant']);

        if (Auth::user()) {
            $exist->updated_by = Auth::user()->id;
            $exist->deleted_by = Auth::user()->id;
        } else {
            $exist->updated_by = "public_user";
            $exist->deleted_by = "public_user";
        }
        $exist->save();
        $exist->delete();

        $request->ic = $existEventParticipant->participant->ic;

        $participant = Participant::where('ic', $request->ic)->first();

        return Redirect()->back();
    }



    public function updatePaymentProof(Request $request)
    {
        if ($request->file('payment_proof_input')) {
            $date = Carbon::today()->toDateString();
            $year = substr($date, 0, 4);
            $month = substr($date, 5, 2);
            $day = substr($date, 8, 2);

            $images = $request->file('payment_proof_input');

            foreach ($images as $image) {
                // Public Folder
                // storage/shortcourse/payment_proof_input/2021/20210809_id19_1707603867289898.png
                // $name_gen = hexdec(uniqid());
                // $img_ext = strtolower($image->getClientOriginalExtension());

                // $img_name = $year . $month . $day . '_id' . ($request->event_id) . '_' . $name_gen . '.' . $img_ext;



                // $up_location = 'storage/shortcourse/payment_proof_input/' . $year . '/';
                // $last_img = $up_location . $img_name;

                // $image->move($up_location, $img_name);

                // EventParticipantPaymentProof::create([
                //     'event_participant_id' => $request->event_participant_id,
                //     'payment_proof_path' => $last_img,
                //     'created_by' => 'public_user',
                // ]);
                // End of Public Folder

                // app/shortcourse/payment_proof_input/2021/20210826_id27_1709125459615751.png
                $name_gen = hexdec(uniqid());
                $img_ext = strtolower($image->getClientOriginalExtension());

                $img_name = $year . $month . $day . '_id' . ($request->event_id) . '_' . $name_gen . '.' . $img_ext;

                $up_location = 'shortcourse/payment_proof_input/' . $year . '/';

                $image->storeAs($up_location, $img_name);
                $web_path = "app/" . $up_location . $img_name;
                $request->merge(['upload_image' => $img_name, 'web_path' => $web_path]);



                EventParticipantPaymentProof::create([
                    'event_participant_id' => $request->event_participant_id,
                    'name' => $img_name,
                    'payment_proof_path' => "app/" . $up_location,
                    'created_by' => 'public_user',
                ]);
            }

            $eventParticipantPaymentProof = EventParticipantPaymentProof::where([['event_participant_id', '=', $request->event_participant_id]])->get();
            $eventParticipant = EventParticipant::find($request->event_participant_id)->load(['participant', 'event.venue']);
            if (count($eventParticipantPaymentProof) > 0 && $eventParticipant->is_verified_payment_proof != 1) {
                $update = EventParticipant::where([['id', '=', $request->event_participant_id]])->update([
                    'is_verified_payment_proof' => 0,
                    'updated_by' => Auth::user() ? Auth::user()->id : 'public_user',
                    'updated_at' => Carbon::now()
                ]);
            }
            $request->ic = $eventParticipant->participant->ic;


            $message =  [
                'opening' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . ($eventParticipant->participant->name),
                'introduction' => 'Bukti pembayaran anda <b>TELAH DIHANTAR dan SEDANG DISEMAK</b> oleh pihak INTEC bagi program, ',
                'detail' => 'Program: ' . ($eventParticipant->event->name)
                    . '<br/>Tarikh: ' . ($eventParticipant->event->datetime_start) . ' sehingga ' . ($eventParticipant->event->datetime_end)
                    . '<br/>Tempat: ' . ($eventParticipant->event->venue->name),
                'conclusion' => 'Sila tunggu maklumbalas dari kami bagi pengesahan pembayaran anda.
                Sebarang pertanyaan boleh terus berhubung dengan kami.
                Kami amat menghargai segala usaha anda. Semoga urusan anda dipermudahkan. Terima kasih.',
                'sha1_ic' => ($eventParticipant->participant->sha1_ic),
            ];

            Mail::send('short-course-management.email.email-payment-verified', $message, function ($message) use ($eventParticipant) {
                $message->subject('Pengesahan Bukti Pembayaran (Telah Dihantar dan Sedang Disemak)');
                $message->from(Auth::user() ? Auth::user()->email : 'corporate@intec.edu.my');
                $message->to($eventParticipant->participant->email);
            });

            return Redirect()->back()->with('successPaymentProofUpdate', 'Payment Proof Updated and Verification Requested successfully');
        }
        $eventParticipantPaymentProof = EventParticipantPaymentProof::where([['event_participant_id', '=', $request->event_participant_id]])->get();
        $eventParticipant = EventParticipant::find($request->event_participant_id)->load(['participant']);
        if (count($eventParticipantPaymentProof) > 0 && $eventParticipant->is_verified_payment_proof != 1) {
            $update = EventParticipant::where([['id', '=', $request->event_participant_id]])->update([
                'is_verified_payment_proof' => 0,
                'updated_by' => Auth::user() ? Auth::user()->id : 'public_user',
                'updated_at' => Carbon::now()
            ]);
        }
        $request->ic = $eventParticipant->participant->ic;

        $participant = Participant::where('ic', $request->ic)->first();
        return Redirect()->back()->with('successPaymentProofUpdate', 'Payment Proof Verification Requested Successfully with No New Payment Proof Uploaded');
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

    public function printCertificate($id)
    {
        $html = "";

        $html = $this->certificateView($id, $html);

        return PDF::loadHtml($html)->stream('Certificate.pdf');
    }
    public function getCertificateBackground()
    {
        $path = storage_path() . '/app/shortcourse/general/Participation-CO-01.jpg';

        $file = File::get($path);
        $filetype = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $filetype);
        return $response;
    }
    public function certificateView($id, $html)
    {
        $eventParticipant = EventParticipant::where('id', $id)->with(['participant', 'event'])->first();


        // $path = storage_path() . '/' . $event_participant_payment_proof->payment_proof_path . $payment_proof_path;

        // $file = File::get($path);
        // $filetype = File::mimeType($path);

        // $response = Response::make($file, 200);
        // $response->header("Content-Type", $filetype)

        $fdate = $eventParticipant->event->datetime_start;
        $tdate = $eventParticipant->event->datetime_end;
        $datetime1 = new DateTime($fdate);
        $datetime2 = new DateTime($tdate);
        $interval = $datetime1->diff($datetime2);
        $days_diff = $interval->format('%a');

        $eventParticipant->event->days_diff = $days_diff;


        return $html .= view('short-course-management.pdf.event-certificate', compact('eventParticipant'));
    }

    private function _progressFlow($eventParticipant_id, $progress_name)
    {
        $eventParticipant = EventParticipant::where('id', $eventParticipant_id)->first()->load(['participant', 'event.venue', 'fee']);

        switch ($progress_name) {

            case 'delete-application':
                $exist1 = EventModuleEventParticipant::where('event_participant_id', $eventParticipant_id)->get();
                if ($exist1) {
                    foreach ($exist1 as $exist) {

                        // $exist->forceDelete();
                        $exist->updated_by = Auth::user()->id;
                        $exist->deleted_by = Auth::user()->id;
                        $exist->save();
                        $exist->delete();
                    }
                }
                $exist2 = EventParticipant::find($eventParticipant_id);
                $exist2->updated_by = Auth::user()->id;
                $exist2->deleted_by = Auth::user()->id;
                $exist2->save();
                $exist2->delete();
                break;
            case 'restore-application':
                $update = EventParticipant::find($eventParticipant_id)->update([
                    'is_disqualified' => 0,
                    'disqualified_datetime' => null,
                ]);
                $message =  [
                    'opening' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . ($eventParticipant->participant->name),
                    'introduction' => 'Pemohonan anda untuk menyertai salah satu program kami <b>TELAH DIAKTIFKAN SEMULA</b> oleh pihak INTEC bagi program, ',
                    'detail' => 'Program: ' . ($eventParticipant->event->name)
                        . '<br/>Tarikh: ' . ($eventParticipant->event->datetime_start) . ' sehingga ' . ($eventParticipant->event->datetime_end)
                        . '<br/>Tempat: ' . ($eventParticipant->event->venue->name)
                        . '<br/> <br/>Sila buat pembayaran yuran sebanyak <b>RM'
                        . ($eventParticipant->fee_amount_applied) . ' (' . ($eventParticipant->fee->name)
                        . ')</b>, kemudian tekan butang di bawah untuk ke sesawang profil bagi mengemaskini status pembayaran untuk disahkan.',
                    'conclusion' => 'Kami amat menghargai segala usaha anda. Semoga urusan anda dipermudahkan. Terima kasih.',
                    'sha1_ic' => ($eventParticipant->participant->sha1_ic),
                ];

                Mail::send('short-course-management.email.email-payment-verified', $message, function ($message) use ($eventParticipant) {
                    $message->subject('Pengesahan Pendaftaran (Berjaya)');
                    $message->from(Auth::user()->email);
                    $message->to($eventParticipant->participant->email);
                });
                break;
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
                        . ($eventParticipant->fee_amount_applied) . ' (' . ($eventParticipant->fee->name)
                        . ')</b>, kemudian tekan butang di bawah untuk ke sesawang profil bagi mengemaskini status pembayaran untuk disahkan.',
                    'conclusion' => 'Kami amat menghargai segala usaha anda. Semoga urusan anda dipermudahkan. Terima kasih.',
                    'sha1_ic' => ($eventParticipant->participant->sha1_ic),
                ];

                Mail::send('short-course-management.email.email-payment-verified', $message, function ($message) use ($eventParticipant) {
                    $message->subject('Pengesahan Pendaftaran (Berjaya)');
                    $message->from(Auth::user()->email);
                    $message->to($eventParticipant->participant->email);
                });
                break;
            case 'reject-application':
                $exist = EventParticipant::find($eventParticipant_id)->load(['participant']);
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
                    'sha1_ic' => ($eventParticipant->participant->sha1_ic),
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
                    'sha1_ic' => ($eventParticipant->participant->sha1_ic),
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
                    'sha1_ic' => ($eventParticipant->participant->sha1_ic),
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
                        . ($eventParticipant->fee_amount_applied) . ' (' . ($eventParticipant->fee->name)
                        . ')</b>, kemudian tekan butang di bawah untuk ke sesawang profil bagi memasukkan bukti pembayaran yang baharu untuk disahkan.',
                    'conclusion' => 'Kami amat menghargai segala usaha anda. Semoga urusan anda dipermudahkan. Terima kasih.',
                    'sha1_ic' => ($eventParticipant->participant->sha1_ic),
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

                $message =  [
                    'opening' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . ($eventParticipant->participant->name),
                    'introduction' => 'Tahniah! Anda telah disahkan sebagai <b>HADIR</b> bagi program, ',
                    'detail' => 'Program: ' . ($eventParticipant->event->name)
                        . '<br/>Tarikh: ' . ($eventParticipant->event->datetime_start) . ' sehingga ' . ($eventParticipant->event->datetime_end)
                        . '<br/>Tempat: ' . ($eventParticipant->event->venue->name),
                    'conclusion' => 'Kami amat menghargai segala usaha anda. Semoga anda terus berjaya. Terima kasih.',
                    'sha1_ic' => ($eventParticipant->participant->sha1_ic),
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
                    'sha1_ic' => ($eventParticipant->participant->sha1_ic),
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
                $message =  [
                    'opening' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . ($eventParticipant->participant->name),
                    'introduction' => 'Tahniah! Anda telah disahkan sebagai <b>HADIR dan LAYAK MEMBUAT MAKLUM BALAS</b> bagi program, ',
                    'detail' => 'Program: ' . ($eventParticipant->event->name)
                        . '<br/>Tarikh: ' . ($eventParticipant->event->datetime_start) . ' sehingga ' . ($eventParticipant->event->datetime_end)
                        . '<br/>Tempat: ' . ($eventParticipant->event->venue->name),
                    'conclusion' => 'Kami amat menghargai segala usaha anda. Semoga anda terus berjaya. Terima kasih.',
                    'sha1_ic' => ($eventParticipant->participant->sha1_ic),
                    'event_participant_id' => ($eventParticipant->id),
                ];

                Mail::send('short-course-management.email.email-payment-verified', $message, function ($message) use ($eventParticipant) {
                    $message->subject('Pengesahan Maklum Balas (Layak Membuat Maklum Balas)');
                    $message->from(Auth::user()->email);
                    $message->to($eventParticipant->participant->email);
                });
                break;
            default:
                break;
        }
    }
}
