<?php

namespace App\Models\ShortCourseManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;
    protected $table = 'scm_question';
    protected $primaryKey = 'id';
    protected $fillable = [
        'question',
        'is_active',
        'section_id',
        'question_type',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at'
    ];

    public function events_participants_questions_answers()
    {
        return $this->hasMany('App\Models\ShortCourseManagement\EventParticipantQuestionAnswer',
        'question_id',
        'id');
    }

    public function section()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\Section', 'section_id', 'id');
    }
}
