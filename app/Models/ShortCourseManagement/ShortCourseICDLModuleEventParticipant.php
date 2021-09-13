<?php

namespace App\Models\ShortCourseManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShortCourseICDLModuleEventParticipant extends Model
{
    use SoftDeletes;
    protected $table = 'scm_shortcourse_icdl_module_event_participant';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'shortcourse_icdl_module_id',
        'event_participant_id',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at'
    ];

    public function shortcourse_icdl_module()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\ShortCourseICDLModule',
        'shortcourse_icdl_module_id',
        'id');
    }

    public function event_participant()
    {
        return $this->belongsTo('App\Models\ShortCourseManagement\EventParticipant',
        'event_participant_id',
        'id');
    }
}
