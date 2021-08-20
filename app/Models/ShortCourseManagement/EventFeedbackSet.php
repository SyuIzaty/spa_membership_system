<?php

namespace App\Models\ShortCourseManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventFeedbackSet extends Model
{
    use SoftDeletes;
    protected $table = 'scm_event_feedback_set';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'description',
        'is_active',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at'
    ];

    public function sections()
    {
        return $this->hasMany('App\Models\ShortCourseManagement\Section',
        'event_feedback_set_id',
        'id');
    }

    public function events()
    {
        return $this->hasMany('App\Models\ShortCourseManagement\Event',
        'event_feedback_set_id',
        'id');
    }
}
