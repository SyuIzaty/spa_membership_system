<?php

namespace App\Models\ShortCourseManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventParticipantPaymentProof extends Model
{
    use SoftDeletes;
    protected $table = 'scm_event_participant_payment_proof';
    protected $primaryKey = 'id';
    protected $fillable = [
        'payment_proof_path',
        'event_participant_id',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at'
    ];

    public function subcategory()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\EventParticipant',
        'event_participant_id',
        'id');
    }
}
