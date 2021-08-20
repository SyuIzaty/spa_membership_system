<?php

namespace App\Models\ShortCourseManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use SoftDeletes;
    protected $table = 'scm_section';
    protected $primaryKey = 'id';
    protected $fillable = [
        'section_number',
        'name',
        'event_feedback_set_id'.
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at'
    ];

    public function questions()
    {
        return $this->hasMany(
            'App\Models\ShortCourseManagement\Question',
            'section_id',
            'id'
        );
    }

    public function event_feedback_set()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\EventFeedbackSet', 'event_feedback_set_id', 'id');
    }
}
