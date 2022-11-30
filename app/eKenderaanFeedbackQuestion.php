<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class eKenderaanFeedbackQuestion extends Model
{
    protected $table = 'ekn_feedback_questions';
    protected $fillable = [
        'question', 'sequence', 'status', 'created_by', 'updated_by', 'deleted_by'
    ];
}
