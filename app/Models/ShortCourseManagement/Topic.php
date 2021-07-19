<?php

namespace App\Models\ShortCourseManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    use SoftDeletes;
    protected $table = 'scm_topic';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'subcategory_id',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at'
    ];

    public function subcategory()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\SubCategory',
        'subcategory_id',
        'id');
    }

    public function shortcourses()
    {
        return $this->hasMany('App\Models\ShortCourseManagement\ShortCourse',
        'topic_id',
        'id');
    }
}
