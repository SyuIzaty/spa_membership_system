<?php

namespace App\Models\ShortCourseManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShortCourse extends Model
{
    use SoftDeletes;
    protected $table = 'scm_shortcourse';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'description',
        'objective',
        'topic_id',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at'
    ];

    public function topic()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\Topic',
         'topic_id',
         'id');
    }
    public function materials()
    {
        return $this->hasMany('App\Models\ShortCourseManagement\Material',
         'shortcourse_id',
         'id');
    }
    public function events_shortcourses()
    {
        return $this->hasMany('App\Models\ShortCourseManagement\EventShortCourse',
         'shortcourse_id',
         'id');
    }
}
