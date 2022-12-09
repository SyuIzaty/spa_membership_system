<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class eKenderaanFeedbackService extends Model
{
    protected $table = 'ekn_feedback_services';
    protected $fillable = [
        'ekn_feedback_questions_id', 'ekn_details_id', 'ekn_assigned_driver_id', 'scale', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function questionList()
    {
        return $this->hasOne(eKenderaanFeedbackQuestion::class, 'id', 'ekn_feedback_questions_id');
    }
}
