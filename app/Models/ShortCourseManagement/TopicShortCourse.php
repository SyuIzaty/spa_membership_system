<?php

namespace App\Models\ShortCourseManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TopicShortCourse extends Model
{
    use SoftDeletes;
    protected $table = 'scm_topic_shortcourse';
    protected $primaryKey = 'id';
    protected $fillable = [
        'topic_id',
        'shortcourse_id',
        'is_active',
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

    public function shortcourse()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\ShortCourse',
        'shortcourse_id',
        'id');
    }
}
