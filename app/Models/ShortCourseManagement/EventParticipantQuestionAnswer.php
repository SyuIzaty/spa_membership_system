<?php

namespace App\Models\ShortCourseManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventParticipantQuestionAnswer extends Model
{
    use SoftDeletes;
    protected $table = 'scm_event_participant_question_answer';
    protected $primaryKey = 'id';
    protected $fillable = [
        'question_id',
        'event_participant_id',
        'rate',
        'description',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at'
    ];

    public function question()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\Question', 'question_id', 'id');
    }

    public function event_participant()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\EventParticipant', 'event_participant_id', 'id');
    }
}
