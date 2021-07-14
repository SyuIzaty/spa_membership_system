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
        'fee_id', 'is_paid',
        'payment_type_id',
        'payment_proof_path',
        'is_verified_payment_proof',
        'payment_datetime',
        'payment_remark',
        'is_approved',
        'approved_datetime',
        'organization_representative_id',
        'is_actively_participate',
        'is_done_email_registration_confirmation',
        'is_done_email_payment_reminder',
        'is_done_email_event_reminder',
        'is_done_email_feedback_reminder',
        'is_done_email_completed',
        'is_done_email_cancellation_disqualified',
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
        return $this->belongsTo('App\Models\ShortCourseManagement\Event', 'id', 'event_id');
    }
    public function participant()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\Participant', 'id', 'participant_id');
    }
    public function fee()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\Fee', 'id', 'fee_id');
    }
    public function payment_type()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\PaymentType', 'id', 'payment_type_id');
    }
    public function organization_representative()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\EventParticipant', 'id', 'organisation_representative_id');
    }
}
