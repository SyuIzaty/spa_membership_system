<?php

namespace App\Models\ShortCourseManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;
    protected $table = 'scm_event';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'description',
        'target_audience',
        'tentative_path',
        'addition_information',
        'thumbnail_path',
        'min_participant',
        'max_participant',
        'objective',
        'datetime_start',
        'datetime_end',
        'is_mainly_online',
        'online_url',
        'online_password',
        'address',
        'registration_due_date',
        'venue_id',
        'event_status_category_id',
        'is_cancelled',
        'cancellation_remark',
        'is_closed_registration',
        'closed_registration_datetime',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at'
    ];

    public function venue()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\Venue', 'venue_id', 'id');
    }

    public function event_status_category()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\EventStatusCategory', 'event_status_category_id', 'id');
    }

    public function events_shortcourses()
    {
        return $this->hasMany('App\Models\ShortCourseManagement\EventShortCourse', 'event_id', 'id');
    }
    public function events_trainers()
    {
        return $this->hasMany('App\Models\ShortCourseManagement\EventTrainer', 'event_id', 'id');
    }
    public function events_participants()
    {
        return $this->hasMany('App\Models\ShortCourseManagement\EventParticipant', 'event_id', 'id');
    }
    public function fees()
    {
        return $this->hasMany('App\Models\ShortCourseManagement\Fee', 'event_id', 'id');
    }
}
