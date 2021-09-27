<?php

namespace App\Models\ShortCourseManagement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventModule extends Model
{
    use SoftDeletes;
    protected $table = 'scm_shortcourse_icdl_module';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'shortcourse_id',
        'event_id',
        'fee_amount',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at'
    ];

    public function shortcourse()
    {
        //Paramenet 1 belongs to parameter 0
        return $this->belongsTo('App\Models\ShortCourseManagement\ShortCourse',
        'shortcourse_id',
        'id');
    }

    public function event()
    {
        //Paramenet 1 belongs to parameter 0
        return $this->belongsTo('App\Models\ShortCourseManagement\Event',
        'event_id',
        'id');
    }

    public function event_modules_event_participants()
    {
        return $this->hasMany('App\Models\ShortCourseManagement\EventModuleEventParticipant',
         'event_module_id',
         'id');
    }
}
