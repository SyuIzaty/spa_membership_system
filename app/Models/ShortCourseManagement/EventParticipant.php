<?php

namespace App\Models\ShortCourseManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventParticipant extends Model
{
    use SoftDeletes;
    protected $table = 'scm_event_participant';
    protected $primaryKey = 'id';
    protected $fillable = [
        'event_id',
        'participant_id',
        'fee_id',
        'fee_amount_applied',
        'is_paid',
        'payment_type_id',
        'payment_proof_path',
        'is_verified_payment_proof',
        'verified_payment_proof_datetime',
        'payment_datetime',
        'payment_remark',
        'is_approved_application',
        'is_approved_participation',
        'approved_application_datetime',
        'approved_participation_datetime',
        'is_question_sended',
        'question_sended_datetime',
        // 'organization_representative_id',
        'participant_representative_id',
        'is_actively_participate',
        'is_done_email_registration_confirmation',
        'is_done_email_application_approval',
        'is_done_email_payment_reminder',
        'is_done_email_participation_approval',
        'is_done_email_event_reminder',
        'is_done_email_feedback_reminder',
        'is_done_email_completed',
        'done_email_completed_datetime',
        'is_done_email_cancellation_disqualified',
        'is_disqualified',
        'disqualified_datetime',
        'is_not_attend',
        'is_active',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at'
    ];


    public function event()
    {
        //Paramenet 1 belongs to parameter 0
        return $this->belongsTo('App\Models\ShortCourseManagement\Event', 'event_id', 'id');
    }
    public function participant()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\Participant', 'participant_id', 'id');
    }
    public function fee()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\Fee', 'fee_id', 'id');
    }
    public function payment_type()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\PaymentType', 'payment_type_id', 'id');
    }
    public function organization_representative()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\EventParticipant', 'organisation_representative_id', 'id');
    }
    public function organization_members_under()
    {
        return $this->hasMany('App\Models\ShortCourseManagement\EventParticipant', 'organisation_representative_id', 'id');
    }
    public function event_participant_payment_proof()
    {
        return $this->hasMany('App\Models\ShortCourseManagement\EventParticipantPaymentProof', 'event_participant_id', 'id');
    }
    public function events_participants_questions_answers()
    {
        return $this->hasMany('App\Models\ShortCourseManagement\EventParticipantQuestionAnswer',
        'question_id',
        'id');
    }
    public function event_modules_event_participants()
    {
        return $this->hasMany('App\Models\ShortCourseManagement\EventModuleEventParticipant',
         'event_participant_id',
         'id');
    }
    // $this->belongsTo(self::class, 'parent_id');
}
