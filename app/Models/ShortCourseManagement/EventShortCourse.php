<?php

namespace App\Models\ShortCourseManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventShortCourse extends Model
{
    use SoftDeletes;
    protected $table = 'scm_event_shortcourse';
    protected $primaryKey = 'id';
    protected $fillable = [
        'event_id', 'shortcourse_id', 'is_active', 'created_by', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at'
    ];

    public function event()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\Event', 'id', 'event_id');
    }

    public function shortcourse()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\ShortCourse', 'id', 'shortcourse_id');
    }
}
