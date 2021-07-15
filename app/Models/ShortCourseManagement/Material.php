<?php

namespace App\Models\ShortCourseManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use SoftDeletes;
    protected $table = 'scm_material';
    protected $primaryKey = 'id';
    protected $fillable = [
        'path','shortcourse_id', 'created_by', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at'
    ];


    public function shortcourses()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\ShortCourse', 'material_id', 'id');
    }
}
